<?php
namespace App\Lib\GameServer;

use App\Lib\GameServer\GameServerInterface;
use App\Models\Account;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\LineageItem;
use App\Models\Auction;
use App\Models\Server;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Facade;


class GameServerType5 implements GameServerInterface
{

    public static function setPasswordAccount($login, $new_password)
    {

        DB::connection('lin2db')->table('accounts')
            ->where('login', $login)
            ->update([
                'password' => $new_password,
            ]);

    }

    public static function validPasswordAccount($login, $password)
    {

        return DB::connection('lin2db')->table('accounts')
            ->where('login', $login)
            ->where('password', DB::raw("CONVERT(VARBINARY(MAX), '{$password}', 2)"))
            ->value('login');

    }

    public static function createGameAccount($account, $password)
    {

        if (DB::connection('lin2db')->table('accounts')->select('login')->where('login', $account->login)->first()) {
            Session::put('alert.danger', ["Аккаунт с таким логином уже существует! Придумайте другой логин"]);
            return FALSE;
        }

        DB::connection('lin2db')->table('accounts')
            ->insertOrIgnore([
                ['login' => $account->login, 'password' => $password],
            ]);
        return TRUE;

    }

    public static function getCharacter($char_id)
    {

        return DB::connection('lin2world')->table('characters')->select('charId as char_id', 'char_name', 'account_name')->where('charId', $char_id)->first();
    }

    public static function getCharacterByName($char_name)
    {

        return DB::connection('lin2world')->table('characters')->select('charId as char_id', 'char_name', 'account_name')->where('char_name', $char_name)->first();

    }

    public static function getCharacters($accounts)
    {

        if (count($accounts) < 1) return [];

        $accounts_list = convertToStrList($accounts);

        return DB::connection('lin2world')
            ->select(DB::raw('SELECT ch.account_name, ch.charId as char_id, ch.char_name as char_name, ch.exp as Exp, ch.level as lvl, ch.pvpkills as Duel, ch.pkkills as PK,
                      ch.online as online, ch.clanid, ch.classid as class, ch.sex as gender, ch.onlinetime as use_time, ch.lastAccess as LastLogin, 0 as BanChar,
                      cl.clan_name as clanName, ch.classid as class_name 
                      FROM characters as ch
                      LEFT JOIN clan_data as cl ON cl.clan_id = ch.clanid
                      WHERE ch.account_name IN(' . $accounts_list . ')
                      ORDER BY ch.charId;'));

    }

    public static function charactersCount($accounts)
    {

        return DB::connection('lin2world')->table('characters')->select('charId as id', 'account_name')->whereIn('account_name', $accounts)->where('charId', '>', 0)->count();

    }

    public static function getUserAccounts($login)
    {

        return DB::connection('lin2db')->table('accounts')->select('login as account', 'lastactive as last_login', 'lastactive as lastactive', 'lastIP as last_ip')->where('login', $login)->first();

    }

    public static function getItems($char_id, $donate_items)
    {

        $items = DB::connection('lin2world')
            ->select(DB::raw('SELECT i.item_id as item_id, i.owner_id, i.item_id as item_type, i.item_id as name, i.enchant_level as enchant, i.enchant_level as icon, i.count as amount, 1 as auction_block
                      FROM items as i
                      WHERE i.owner_id = '.$char_id.'
                      ORDER BY i.item_id;'));

        foreach ($items as $item) {
            $lineage_item = LineageItem::select('icon0', 'name')->where('id', $item->item_type)->first();
            $item->icon = $lineage_item->icon0;
            $item->name = $lineage_item->name;
        }

        return $items;

    }

    public static function getItem($char_id, $item_id)
    {

        $item = DB::connection('lin2world')->table('items as i')
            ->select(DB::raw('i.item_id as item_id, i.owner_id, i.item_id as item_type, i.item_id as name, i.enchant_level as enchant, i.is_blessed as bless,
             0 as eroded, i.custom_type1 as variation_opt1, i.custom_type2 as variation_opt2, i.item_id as intensive_item_type, i.owner_id as ident,
                      i.enchant_level as wished, i.count as amount, i.enchant_level as icon'))
            ->where('i.item_id', '=', $item_id)
            ->where('i.owner_id', '=', $char_id)
            ->first();

        if ($item) {
            $lineage_item = LineageItem::select('icon0', 'name')->where('id', $item->item_type)->first();
            $item->icon = $lineage_item->icon0;
            $item->name = $lineage_item->name;
        }

        return $item;

    }

    public static function checkNameCharacter($nickname)
    {

        return DB::connection('lin2world')->table('characters')->where('char_name', $nickname)->doesntExist();

    }

    public static function teleportCharacterMainTown($char_id, $town_cord)
    {
        DB::connection('lin2world')->table('characters')
            ->where('charId', $char_id)
            ->update([
                'x' => $town_cord['x'],
                'y' => $town_cord['y'],
                'z' => $town_cord['z'],
            ]);
        return TRUE;
    }

    public static function transferItemWarehouse($char_id, $item_id, $amount, $inventory)
    {

        $amount = abs($amount);

        $l2_item = DB::connection('lin2world')->table('items')->where('owner_id', $char_id)->where('item_id', $item_id)->first();
        if (!$l2_item) {
            return FALSE;
        }

        if ($l2_item->count - $amount > 0) {
            DB::connection('lin2world')->table('items')
                ->where('owner_id', $char_id)
                ->where('item_id', $item_id)
                ->decrement('count', $amount);
        } else {
            DB::connection('lin2world')->table('items')
                ->where('owner_id', $char_id)
                ->where('item_id', $item_id)
                ->delete();
        }

        $exist_item = Warehouse::where('type', $inventory->item_id)
            ->where('enchant', $inventory->enchant)
            ->where('bless', $inventory->bless)
            ->where('eroded', $inventory->eroded)
            ->where('ident', $inventory->ident)
            ->where('wished', $inventory->wished)
            ->where('variation_opt1', $inventory->variation_opt1)
            ->where('variation_opt2', $inventory->variation_opt2)
            ->where('intensive_item_type', $inventory->intensive_item_type)
            ->where('user_id', auth()->id())
            ->where('server', session('server_id'))
            ->first();

        if ($exist_item) {
            $exist_item->increment('amount', $amount);
        } else {
            $warehouse = new Warehouse;
            $warehouse->type = $inventory->item_id;
            $warehouse->amount = $amount;
            $warehouse->enchant = $inventory->enchant;
            $warehouse->bless = $inventory->bless;
            $warehouse->eroded = $inventory->eroded;
            $warehouse->ident = $inventory->ident;
            $warehouse->wished = $inventory->wished;
            $warehouse->variation_opt1 = $inventory->variation_opt1;
            $warehouse->variation_opt2 = $inventory->variation_opt2;
            $warehouse->intensive_item_type = $inventory->intensive_item_type;
            $warehouse->user_id = auth()->id();
            $warehouse->server = session('server_id');
            $warehouse->save();
        }

        return TRUE;
    }

    public static function transferItemGameServer($char_id, $character, $amount, $warehouse)
    {

        //Если товар есть у игрового персонажа, то увеличиваем ему кол-во
        if (DB::connection('lin2world')->table('items')
            ->where('owner_id', $char_id)
            ->where('item_id', $warehouse->type)
            ->increment('count', $amount)) {

            return TRUE;
        }

        //Если товара нет у игрового персонажа, то добавляем его

        $last = DB::connection('lin2world')->table('items')->select('object_id')->latest('object_id')->first();
        if (isset($last->object_id)) {
            $last = $last->object_id + 1;
        } else {
            $last = 1;
        }
        DB::connection('lin2world')->table('items')
            ->insert([
                'owner_id'      => $char_id,
                'object_id'     => $last,
                'item_id'       => $warehouse->type,
                'count'         => $amount,
                'enchant_level' => $warehouse->enchant,
                'is_blessed'    => 0,
                'loc'           => 'INVENTORY',
                'loc_data'      => 0,
                'time_of_use'   => NULL,
                'custom_type1'  => $warehouse->variation_opt1,
                'custom_type2'  => $warehouse->variation_opt2,
                'mana_left'     => $warehouse->bless,
                'time'          => '',
                'pet_id'        => 0,
            ]);

        return TRUE;
    }

    public static function transferDonateGameServer($char_id, $character, $amount)
    {

        Log::channel('paypal')->info("database.l2word_db_type: " . config('database.l2word_db_type'));
        $item_id = '91408'; //игровая валюта COL

        Log::channel('paypal')->info("owner_id: " . $char_id . ", item_id: " . $item_id . ", count: " . $amount);

        /*
        DB::connection('lin2world')->table('items_delayed')
            ->insertOrIgnore([
                ['payment_id' => 0, 'owner_id' => $char_id, 'item_id' => $item_id, 'count' => $amount, 'enchant_level' => 0, 'attribute' => -1, 'attribute_level' => -1, 'flags' => 0, 'payment_status' => 0],
            ]);
        return TRUE;
        */

        //Если коины есть у игрового персонажа, то увеличиваем их кол-во
        if (DB::connection('lin2world')->table('items')
            ->where('owner_id', $char_id)
            ->where('item_id', $item_id)
            ->increment('count', $amount)) {

            return TRUE;
        }

        $last = DB::connection('lin2world')->table('items')->select('object_id')->latest('object_id')->first();

        //Если коинов нет у игрового персонажа, то добавляем их
        DB::connection('lin2world')->table('items')
            ->insert([
                'owner_id'            => (int)$char_id,
                'object_id'           => (int)$last->object_id + 1,
                'item_id'             => (int)$item_id,
                'count'               => (int)$amount,
                'enchant_level'       => 0,
                'loc'                 => 'INVENTORY',
                'loc_data'            => 1,
                'life_time'           => -1,
                'variation_stone_id'  => 0,
                'variation1_id'       => 0,
                'variation2_id'       => 0,
                'custom_type1'        => 0,
                'custom_type2'        => 0,
                'custom_flags'        => 0,
                'agathion_energy'     => 0,
                'appearance_stone_id' => 0,
                'visual_id'           => 0,
            ]);

        return TRUE;

    }

    public static function changeNameCharacter($char_id, $nickname)
    {

        DB::connection('lin2world')->table('characters')
            ->where('charId', $char_id)
            ->update([
                'char_name' => $nickname,
            ]);
        return TRUE;

    }

    public static function changeColorCharacter($char_id, $type, $color)
    {

        $type_color = ($type == 1) ? 'titleColor' : 'nameColor';
        DB::connection('lin2world')->table('character_data')
            ->updateOrInsert(
                ['charId' => $char_id, 'valueName' => $type_color],
                ['valueData' => $color]
            );
        return TRUE;
    }

    public static function server_rating()
    {

        $castles = DB::connection('lin2world')
            ->select(DB::raw('SELECT c.name as name, c.id, 0 as tax_rate, 0 as newTaxPercent, c.siegeDate as newTaxDate, c.treasury, c.siegeDate as next_war_time, cd.clan_name as clan_name, cd.leader_id, ch.char_name as char_name
                                        FROM castle as c
                                        LEFT OUTER JOIN clan_data as cd ON cd.hasCastle = c.id
                                        LEFT OUTER JOIN characters as ch ON ch.charId = cd.leader_id

                                        ORDER BY c.id;'));

        $agit = DB::connection('lin2world')
            ->select(DB::raw('SELECT clh.id, clh.id as name, clh.ownerId, 0 as location, csp.name as clan_name, ch.char_name as char_name
                                        FROM clanhall as clh
                                        LEFT OUTER JOIN clan_data as cl ON cl.clan_id = clh.ownerId
                                        LEFT OUTER JOIN clan_subpledges as csp ON csp.clan_id = cl.clan_id
                                        LEFT OUTER JOIN characters as ch ON ch.charId = clh.ownerId
                                        ORDER BY clh.id;'));

        $top_query = "SELECT cl.clan_id, csp.name as p_name, cl.clan_level, cl.hasCastle as castle, cl.ally_id, cl.ally_name, cl.leader_id as ownerId, cl.clan_exp as skill_level, cl.crest_id as clanCrestId, cl.ally_crest_id as allyCrestId,
                                c.name as castle_name, ch.char_name as clanholl_name, cl.crest_id as member_count, cl.blood_alliance_count as pvp
                                FROM clan_data as cl
                                LEFT JOIN clan_subpledges as csp ON csp.clan_id = cl.clan_id
                                LEFT JOIN castle as c ON c.id=cl.hasCastle
                                LEFT JOIN characters as ch ON ch.charId=csp.leader_id
                                LEFT JOIN clanhall as clh ON clh.ownerId = cl.leader_id
                                ";
        $top_clan = DB::connection('lin2world')->select(DB::raw($top_query) . 'ORDER BY cl.clan_level DESC, cl.clan_exp DESC, csp.name ASC;');
        $top_clan_pvp = DB::connection('lin2world')->select(DB::raw($top_query) . 'ORDER BY cl.clan_exp DESC, csp.name ASC;');

        $top_query = "SELECT ch.account_name, ch.charId, ch.char_name as char_name, ch.exp as Exp, ch.level as Lev, ch.pvpkills as Duel, ch.pkkills as PK, ch.online as char_online, ch.clanid, ch.classid as class, ch.onlinetime as use_time, csp.name as p_name, ch.classid as class_name 
                                    FROM characters as ch
                                    LEFT JOIN clan_data as cl ON cl.clan_id = ch.clanid
                                    LEFT JOIN clan_subpledges as csp ON csp.leader_id = ch.charId
                                    WHERE ch.charId>0";

        $top_players_pk = DB::connection('lin2world')->select(DB::raw($top_query . ' ORDER BY ch.pkkills DESC;'));
        $top_players_pvp = DB::connection('lin2world')->select(DB::raw($top_query . ' ORDER BY ch.pvpkills DESC;'));
        $top_players_time = DB::connection('lin2world')->select(DB::raw($top_query . ' AND ch.level > 40 ORDER BY Exp DESC;'));


        $result = (object)array(
            'pvp'            => array_slice($top_players_pvp, 0, 15),
            'pk'             => array_slice($top_players_pk, 0, 15),
            'exp'            => array_slice($top_players_time, 0, 15),
            'castles'        => array_slice($castles, 0, 15),
            'clan'           => array_slice($top_clan, 0, 15),
            'clan_pvp'       => array_slice($top_clan_pvp, 0, 15),
            'agit'           => array_slice($agit, 0, 15),
            'last_update_at' => now(),
        );

        return $result;

    }

    public static function online_count($server_id='1')
    {
        $server = Server::where('id', $server_id)->first();
        $options = json_decode($server->options);

        //Записываем в конфиг подключения значения для текущего сервера
        config(['database.ip' => $options->ip]);
        config(['database.l2word_db_type' => $options->l2world_db_type]);

        config(['database.connections.lin2world_' . $server_id => array(
            'driver' => 'mysql',
            'url' => '',
            'host' => $options->lin2world_host,
            'port' => $options->lin2world_port,
            'database' => $options->lin2world_database,
            'username' => $options->lin2world_username,
            'password' => $options->lin2world_password,
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        )]);

        return DB::connection('lin2world_'.$server_id)->table('characters')->select('char_name')->where('online', '1')->count();

    }

    public static function getAccountHWID($account_name)
    {
        return FALSE;

        $account = DB::connection('lin2db')->table('user_account')->where('account', $account_name)->first();
        if ($account && $account->hkey != NULL) {
            return $account->hkey;
        } else {
            return FALSE;
        }
    }

}
