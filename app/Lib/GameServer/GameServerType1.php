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
use Illuminate\Support\Collection;

class GameServerType1 implements GameServerInterface
{

    public static function createGameAccount(object $account, string $salt, string $verifier, string $email, int $server_id)
    {
        self::configWowdb($server_id);

        if (DB::connection('wowdb')->table('account')->select('username')->where('username', $account->login)->first()) {
            Session::put('alert.danger', [__("Аккаунт с таким логином уже существует! Придумайте другой логин!")]);
            return FALSE;
        }
        $id = DB::connection('wowdb')->table('account')
            ->insertGetId(
                [
                    'username'         => $account->login,
                    'salt'             => $salt,
                    'verifier'         => $verifier,
                    'session_key_auth' => '',
                    'session_key_bnet' => '',
                    'totp_secret'      => '',
                    'email'            => $email,
                    'reg_mail'         => '',
                    'joindate'         => '',
                    'last_ip'          => '',
                    'last_attempt_ip'  => '',
                    'failed_logins'    => '0',
                    'locked'           => '0',
                    'lock_country'     => '00',
                    'last_login'       => '',
                    'online'           => 0,
                    'expansion'        => 2,
                    'mutetime'         => 0,
                    'mutereason'       => '',
                    'muteby'           => '',
                    'locale'           => 0,
                    'os'               => 'Win',
                    'recruiter'        => 0,
                    'sha_pass_hash'    => NULL,
                    'dp'               => '',
                    'IP'               => '',
                ]);

        return $id ?: '0';
    }

    public static function changeGameAccountDisplayname($data) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (!DB::connection('wowdb')->table('account')->select('id')->where('id', $data['wow_id'])->first()) {
                    Session::put('alert.danger', [__("Аккаунт с таким логином не найден! Обратитесь в техподдержку!")]);
                    return false;
                }
                DB::connection('wowdb')->table('account')
                    ->where('id', $data['wow_id'])
                    ->update([
                        'display_name' => $data['display_name']
                    ]);
                return true;
            default:
                return false;
        }
    }

    public static function changeGameAccountEmail($data) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (!DB::connection('wowdb')->table('account')->select('id')->where('id', $data['wow_id'])->first()) {
                    Session::put('alert.danger', [__("Аккаунт с таким логином не найден! Обратитесь в техподдержку!")]);
                    return false;
                }
                DB::connection('wowdb')->table('account')
                    ->where('id', $data['wow_id'])
                    ->update([
                        'email' => $data['email']
                    ]);
                return true;
            default:
                return false;
        }
    }

    public static function changeGameAccountPassword($data) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                $account = DB::connection('wowdb')->table('account')->select('id', 'username')->where('id', $data['wow_id'])->first();
                if (!$account) {
                    Session::put('alert.danger', [__("Аккаунт с таким логином не найден! Обратитесь в техподдержку!")]);
                    return false;
                }

                DB::connection('wowdb')->table('account')
                    ->where('id', $data['wow_id'])
                    ->update([
                        'sha_pass_hash' => generationPassword($account->username, $data['password'])
                    ]);
                return true;
            default:
                return false;
        }
    }

    public static function getGameAccount(?string $login, int $server_id=1)
    {
        self::configWowdb($server_id);

        return DB::connection('wowdb_' . $server_id)->table('account')->where('username', $login)->first();
    }

    public static function getGameAccountGMLvl(?int $account_id, int $server_id=1)
    {
        self::configWowdb($server_id);

        $gmlvl = 0;
        $account_access = DB::connection('wowdb_' . $server_id)->table('account_access')->where('AccountID', $account_id)->first();

        if ($account_access) {
            $gmlvl = $account_access->SecurityLevel;
        }

        return $gmlvl;
    }

    public static function activateGameAccountAlphakey($account_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (!DB::connection('wowdb')->table('account')->select('id')->where('id', $account_id)->first()) {
                    Session::put('alert.danger', [__("Аккаунт с таким логином не найден! Обратитесь в техподдержку!")]);
                    return false;
                }
                DB::connection('wowdb')->table('account')
                    ->where('id', $account_id)
                    ->update([
                        'custom_flags' => '4'
                    ]);
                return true;
            default:
                return false;
        }
    }

    public static function checkBannedGameAccount($account_id) {

        $time = strtotime(date('Y-m-d H:i:s')) - 60*60*24*180;
        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowdb')->table('account_banned')
                    ->select('id', 'bandate', 'active')
                    ->where('id', $account_id)
                    ->where('bandate', '>', $time)
                    ->orWhere('active', '1')
                    ->first();
            default:
                return false;
        }
    }

    public static function getGameCharacters(?int $account_id, int $server_id=1)
    {
        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->where('account', $account_id)->get();
    }

    public static function getGameCharacter(?int $char_id, int $server_id=1)
    {
        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->where('guid', $char_id)->first();
    }

    public static function getCharactersCount(?int $account_id, int $server_id)
    {
        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->where('account', $account_id)->count();
    }

    public static function getCharactersPlayTime(?int $account_id, int $server_id)
    {
        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->select('totaltime')->where('account', $account_id)->sum('totaltime');
    }

    public static function checkGameCharacter($char_id, $account_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')->table('characters')->select('guid', 'name', 'account as account_id')->where('account', $account_id)->where('guid', $char_id)->first();
            default:
                return false;
        }
    }

    public static function checkOnlineGameCharacter($char_id, $account_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')->table('characters')
                    ->select('guid', 'name', 'account as account_id')
                    ->where('account', $account_id)
                    ->where('guid', $char_id)
                    ->where('online', '1')
                    ->first();
            default:
                return false;
        }
    }

    public static function checkLvlTimeGameCharacter($char_id, $account_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')->table('characters')
                    ->select('guid', 'name', 'account as account_id')
                    ->where('account', $account_id)
                    ->where('guid', $char_id)
                    ->where('level', '>=', '110')
                    ->where('leveltime', '>=', '172800')
                    ->first();
            default:
                return false;
        }
    }

    public static function getGameCharacterInventory($char_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')
                    ->table('character_inventory')
                    ->select('character_inventory.guid', 'bag', 'slot', 'item', 'item_instance.bonuses', 'custom_flags')
                    ->leftJoin('item_instance', 'item_instance.itemEntry', '=', 'character_inventory.item')
                    ->where('character_inventory.guid', $char_id)
                    ->get();
            default:
                return false;
        }
    }

    public static function getItemGameCharacterInventory($char_id, $item_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')
                    ->table('character_inventory')
                    ->select('character_inventory.guid', 'bag', 'slot', 'item', 'item_instance.bonuses')
                    ->leftJoin('item_instance', 'item_instance.itemEntry', '=', 'character_inventory.item')
                    ->where('character_inventory.guid', $char_id)
                    ->where('character_inventory.item', $item_id)
                    ->get();
            default:
                return false;
        }
    }

    public static function getGameItemSparse($item_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld2')->table('735_ItemSparse')->where('ROW_ID', $item_id)->first();
            default:
                return false;
        }
    }

    public static function checkGameCharacterItem24hours($char_id, $item_id) {

        $time = strtotime(date('Y-m-d H:i:s')) - 60*60*24;
        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                return DB::connection('wowworld')->table('item_instance')
                    ->where('owner_guid', $char_id)
                    ->where('itemEntry', $item_id)
                    ->where('AcquiredDate', '>', $time)
                    ->first();
            default:
                return false;
        }
    }

    public static function lockGameCharacter($id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (DB::connection('wowworld')->table('characters')->where('guid', $id)->update(['account' => 0])) {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }

    public static function unlockGameCharacter($id, $account_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (DB::connection('wowworld')->table('characters')->where('guid', $id)->update(['account' => $account_id])) {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }

    public static function lockGameItemCharacter($char_id, $item_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (DB::connection('wowworld')->table('character_inventory')->where('guid', $char_id)->where('item', $item_id)->delete()) {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }

    public static function unlockGameItemCharacter($char_id, $item_id) {

        //Проверяем тип игровой БД
        switch (config('database.wowword_db_type')) {
            case '1':
                if (DB::connection('wowworld')->table('character_inventory')->where('guid', $char_id)->where('item', $item_id)->delete()) {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }




    public static function setPasswordAccount($login, $new_password)
    {
        DB::connection('wowdb')->table('accounts')
            ->where('login', $login)
            ->update([
                'password' => $new_password,
            ]);

    }

    public static function validPasswordAccount($login, $password)
    {
        return DB::connection('wowdb')->table('accounts')
            ->where('login', $login)
            ->where('password', DB::raw("CONVERT(VARBINARY(MAX), '{$password}', 2)"))
            ->value('login');

    }

    public static function getCharacter($char_id)
    {

        return DB::connection('wowworld')->table('characters')->select('charId as char_id', 'char_name', 'account_name')->where('charId', $char_id)->first();
    }

    public static function getCharacterByName($char_name)
    {

        return DB::connection('wowworld')->table('characters')->select('charId as char_id', 'char_name', 'account_name')->where('char_name', $char_name)->first();

    }


    public static function getCharacters(?int $account_id, int $server_id)
    {
        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->where('account', $account_id)->get();
    }



    public static function getUserAccounts($login)
    {

        return DB::connection('wowdb')->table('accounts')->select('login as account', 'lastactive as last_login', 'lastactive as lastactive', 'lastIP as last_ip')->where('login', $login)->first();

    }

    public static function getItems($char_id, $donate_items)
    {

        $items = DB::connection('wowworld')
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

        $item = DB::connection('wowworld')->table('items as i')
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

        return DB::connection('wowworld')->table('characters')->where('char_name', $nickname)->doesntExist();

    }

    public static function teleportCharacterMainTown($char_id, $town_cord)
    {
        DB::connection('wowworld')->table('characters')
            ->where('charId', $char_id)
            ->update([
                'x' => $town_cord['x'],
                'y' => $town_cord['y'],
                'z' => $town_cord['z'],
            ]);
        return true;
    }

    public static function transferItemWarehouse($char_id, $item_id, $amount, $inventory)
    {

        $amount = abs($amount);

        $l2_item = DB::connection('wowworld')->table('items')->where('owner_id', $char_id)->where('item_id', $item_id)->first();
        if (!$l2_item) {
            return FALSE;
        }

        if ($l2_item->count - $amount > 0) {
            DB::connection('wowworld')->table('items')
                ->where('owner_id', $char_id)
                ->where('item_id', $item_id)
                ->decrement('count', $amount);
        } else {
            DB::connection('wowworld')->table('items')
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
        if (DB::connection('wowworld')->table('items')
            ->where('owner_id', $char_id)
            ->where('item_id', $warehouse->type)
            ->increment('count', $amount)) {

            return TRUE;
        }

        //Если товара нет у игрового персонажа, то добавляем его

        $last = DB::connection('wowworld')->table('items')->select('object_id')->latest('object_id')->first();
        if (isset($last->object_id)) {
            $last = $last->object_id + 1;
        } else {
            $last = 1;
        }
        DB::connection('wowworld')->table('items')
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
        DB::connection('wowworld')->table('items_delayed')
            ->insertOrIgnore([
                ['payment_id' => 0, 'owner_id' => $char_id, 'item_id' => $item_id, 'count' => $amount, 'enchant_level' => 0, 'attribute' => -1, 'attribute_level' => -1, 'flags' => 0, 'payment_status' => 0],
            ]);
        return TRUE;
        */

        //Если коины есть у игрового персонажа, то увеличиваем их кол-во
        if (DB::connection('wowworld')->table('items')
            ->where('owner_id', $char_id)
            ->where('item_id', $item_id)
            ->increment('count', $amount)) {

            return TRUE;
        }

        $last = DB::connection('wowworld')->table('items')->select('object_id')->latest('object_id')->first();

        //Если коинов нет у игрового персонажа, то добавляем их
        DB::connection('wowworld')->table('items')
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
        DB::connection('wowworld')->table('characters')
            ->where('charId', $char_id)
            ->update([
                'char_name' => $nickname
            ]);
        return true;
    }

    public static function changeColorCharacter($char_id, $type, $color)
    {
        $type_color = ($type == 1) ? 'titleColor' : 'nameColor';
        DB::connection('wowworld')->table('character_data')
            ->updateOrInsert(
                ['charId' => $char_id, 'valueName' => $type_color],
                ['valueData' => $color]
            );
        return true;
    }

    public static function server_rating()
    {

        $castles = DB::connection('wowworld')
            ->select(DB::raw('SELECT c.name as name, c.id, 0 as tax_rate, 0 as newTaxPercent, c.siegeDate as newTaxDate, c.treasury, c.siegeDate as next_war_time, cd.clan_name as clan_name, cd.leader_id, ch.char_name as char_name
                                        FROM castle as c
                                        LEFT OUTER JOIN clan_data as cd ON cd.hasCastle = c.id
                                        LEFT OUTER JOIN characters as ch ON ch.charId = cd.leader_id

                                        ORDER BY c.id;'));

        $agit = DB::connection('wowworld')
            ->select(DB::raw('SELECT clh.id, clh.id as name, clh.ownerId, 0 as location, csp.name as clan_name, ch.char_name as char_name
                                        FROM clanhall as clh
                                        LEFT OUTER JOIN clan_data as cl ON cl.clan_id = clh.ownerId
                                        LEFT OUTER JOIN clan_subpledges as csp ON csp.clan_id = cl.clan_id
                                        LEFT OUTER JOIN characters as ch ON ch.charId = clh.ownerId
                                        ORDER BY clh.id;'));

        $top_query = "SELECT cl.clan_id, csp.name as p_name, cl.clan_level, cl.hasCastle as castle, cl.ally_id, cl.ally_name, cl.leader_id as ownerId, cl.reputation_score as skill_level, cl.clanCrestId as clanCrestId, cl.allyCrestId as allyCrestId,
                                c.name as castle_name, clh.name as clanholl_name, 0 as member_count, cl.reputation_score as pvp
                                FROM clan_data as cl
                                LEFT JOIN clan_subpledges as csp ON csp.clan_id = cl.clan_id
                                LEFT JOIN castle as c ON c.id=cl.hasCastle
                                LEFT JOIN characters as ch ON ch.charId=csp.leader_id
                                LEFT JOIN clanhall as clh ON clh.ownerId = cl.leader_id
                                ";
        $top_clan = DB::connection('wowworld')->select(DB::raw($top_query) . 'ORDER BY cl.clan_level DESC, cl.clan_level DESC, csp.name ASC;');
        $top_clan_pvp = DB::connection('wowworld')->select(DB::raw($top_query) . 'ORDER BY cl.clan_level DESC, csp.name ASC;');

        $top_query = "SELECT ch.account_name, ch.charId, ch.char_name as char_name, ch.exp as Exp, ch.level as Lev, ch.pvpkills as Duel, ch.pkkills as PK, ch.online as char_online, ch.clanid, ch.classid as class, ch.onlinetime as use_time, csp.name as p_name, ch.classid as class_name
                                    FROM characters as ch
                                    LEFT JOIN clan_data as cl ON cl.clan_id = ch.clanid
                                    LEFT JOIN clan_subpledges as csp ON csp.leader_id = ch.charId
                                    WHERE ch.charId>0";

        $top_players_pk = DB::connection('wowworld')->select(DB::raw($top_query . ' ORDER BY ch.pkkills DESC;'));
        $top_players_pvp = DB::connection('wowworld')->select(DB::raw($top_query . ' ORDER BY ch.pvpkills DESC;'));
        $top_players_time = DB::connection('wowworld')->select(DB::raw($top_query . ' AND ch.level > 40 ORDER BY Exp DESC;'));


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

    public static function searchGameAccountByCharacter($character)
    {
        $accounts = new Collection();
        foreach (getservers() as $server) {
            $options = json_decode($server->options);

            //Записываем в конфиг подключения значения для текущего сервера
            config(['database.ip' => $options->ip]);
            config([
                'database.connections.wowworld_' . $server->id => array(
                    'driver'         => 'mysql',
                    'url'            => '',
                    'host'           => $options->wowworld_host,
                    'port'           => $options->wowworld_port,
                    'database'       => $options->wowworld_database,
                    'username'       => $options->wowworld_username,
                    'password'       => $options->wowworld_password,
                    'charset'        => 'utf8',
                    'prefix'         => '',
                    'prefix_indexes' => TRUE,
                )
            ]);

            $accounts_result = DB::connection('wowworld_' . $server->id)->table('characters')->select('charId as id', 'account_name')->where('char_name', $character)->get();

            $accounts = $accounts->merge($accounts_result);

        }

        return $accounts;
    }

    public static function getAccountHWID($account_name)
    {
        return FALSE;

        $account = DB::connection('wowdb')->table('user_account')->where('account', $account_name)->first();
        if ($account && $account->hkey != NULL) {
            return $account->hkey;
        } else {
            return FALSE;
        }
    }

    public static function getOnlineCount($server_id=1)
    {

        if (auth()->id() === 497) {
            self::configWowdb($server_id);
            //dd(DB::connection('wowdb_' . $server_id)->table('account')->get());
        }

        self::configWowworld($server_id);

        return DB::connection('wowworld_' . $server_id)->table('characters')->select('char_name')->where('online', '1')->count();
    }

    public static function getStatus($server_id=1)
    {
        $status = 'Offline';

        $server = Server::where('id', $server_id)->first();
        $options = json_decode($server->options);

        $ip_port = explode(':', $options->ip);
        $ip = $ip_port[0];
        $port = $ip_port[1];

        $fp = @fsockopen($ip, $port, $errno, $errstr, 1);
        if ($fp) {
            $pck = pack("vCi", 7, 0, -3);
            fwrite($fp, $pck);
            socket_set_timeout($fp, 1);
            $st = fread($fp, 73);

            if ($st) {
                fclose($fp);
                $status = 'Online';
            }
        }

        return $status;

    }

    private static function configWowdb(int $server_id)
    {
        $server = Server::where('id', $server_id)->first();
        $options = json_decode($server->options);

        //Записываем в конфиг подключения значения для текущего сервера
        config(['database.ip' => $options->ip]);
        config(['database.wowword_db_type' => $options->wowword_db_type]);
        config(['database.connections.wowdb_' . $server_id => array(
            'driver' => 'mysql',
            'url' => '',
            'host' => $options->wowdb_host,
            'port' => $options->wowdb_port,
            'database' => $options->wowdb_database,
            'username' => $options->wowdb_username,
            'password' => $options->wowdb_password,
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        )]);
    }

    private static function configWowworld(int $server_id)
    {
        $server = Server::where('id', $server_id)->first();
        $options = json_decode($server->options);

        //Записываем в конфиг подключения значения для текущего сервера
        config(['database.ip' => $options->ip]);
        config(['database.wowword_db_type' => $options->wowword_db_type]);
        config(['database.connections.wowworld_' . $server_id => array(
            'driver' => 'mysql',
            'url' => '',
            'host' => $options->wowworld_host,
            'port' => $options->wowworld_port,
            'database' => $options->wowworld_database,
            'username' => $options->wowworld_username,
            'password' => $options->wowworld_password,
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        )]);
    }

}
