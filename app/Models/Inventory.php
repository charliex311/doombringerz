<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    protected $lineage_item;
    protected $connection = 'lin2world';
    protected $table = 'user_item';

    protected $appends = [
        'icon', 'name', 'auction_block'
    ];

    public function getIconAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'auction_block')->where('id', $this->item_type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->icon0;
        }
        return '';
    }

    public function getNameAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'auction_block')->where('id', $this->item_type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->name;
        }
        return '';
    }

    public function getAuctionBlockAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'auction_block')->where('id', $this->item_type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->auction_block;
        }
        return 1;
    }

    public static function getItems($char_id, $donate_items) {

        //Проверяем тип игровой БД
        switch (config('database.l2word_db_type')) {

            case '1':
                return DB::connection('lin2world')->table('items')->select('item_id', 'item_type', 'amount', 'enchant')
                    ->whereNotIn('item_type', $donate_items)
                    ->where('char_id', $char_id)
                    ->where('warehouse', 0)->get();
                $items->append('icon');
                $items->append('name');
                $items->append('auction_block');

            case '2':
                return DB::connection('lin2world')->table('items')->select('item_id', 'item_type', 'amount', 'enchant')
                    ->whereNotIn('item_type', $donate_items)
                    ->where('char_id', $char_id)
                    ->where('warehouse', 0)->get();
                $items->append('icon');
                $items->append('name');
                $items->append('auction_block');

            case '3':
                return DB::connection('lin2world')
                    ->select(DB::raw('SELECT i.item_id, i.owner_id, ei.item_type, ei.name, i.enchant_level as enchant, SUBSTRING_INDEX(iic.icon, ".", -1) as icon, i.count as amount, ei.tradeable as auction_block
                      FROM items as i
                      LEFT JOIN etcitem as ei ON ei.item_id = i.item_id
                      LEFT JOIN item_icons as iic ON iic.itemId = i.item_id
                      WHERE i.owner_id = '.$char_id.'
                      ORDER BY i.item_id;'));

            case '4':
                return DB::connection('lin2world')
                    ->select(DB::raw('SELECT i.item_id as item_id, i.owner_id, i.item_id as item_type, i.item_id as name, i.enchant_level as enchant, i.enchant_level as icon, i.count as amount, 1 as auction_block
                      FROM items as i
                      WHERE i.owner_id = '.$char_id.'
                      ORDER BY i.item_id;'));

            default:
                return 0;
        }

    }

    public static function getItem($char_id, $item_id) {

        //Проверяем тип игровой БД
        switch (config('database.l2word_db_type')) {

            case '1':
                //
            case '2':
                return Inventory::select('item_id', 'item_type', 'amount', 'enchant')
                    ->where('item_id', $item_id)
                    ->where('char_id', $char_id)->firstOrFail();

            case '3':
                return DB::connection('lin2world')->table('items as i')
                    ->select(DB::raw('i.item_id, i.owner_id, ei.item_type, ei.name, i.enchant_level as enchant, i.mana_left as bless, ei.destroyable as eroded,
                     i.object_id as intensive_item_type, i.custom_type1 as variation_opt1, i.custom_type2 as variation_opt2, i.creator_id as ident,
                      ei.dropable as wished, i.count as amount, SUBSTRING_INDEX(iic.icon, ".", -1) as icon'))
                    ->leftJoin('etcitem as ei', 'ei.item_id', '=', 'i.item_id')
                    ->leftJoin('item_icons as iic', 'iic.itemId', '=', 'i.item_id')
                    ->where('i.item_id', '=', $item_id)
                    ->where('i.owner_id', '=', $char_id)
                    ->first();

            case '4':
                return DB::connection('lin2world')->table('items as i')
                    ->select(DB::raw('i.item_id as item_id, i.owner_id, i.item_id as item_type, i.item_id as name, i.enchant_level as enchant, i.enchant_level as bless, i.variation_stone_id as eroded,
                     i.object_id as intensive_item_type, i.variation1_id as variation_opt1, i.variation2_id as variation_opt2, i.owner_id as ident,
                      i.enchant_level as wished, i.count as amount, i.enchant_level as icon'))
                    ->where('i.item_id', '=', $item_id)
                    ->where('i.owner_id', '=', $char_id)
                    ->first();

            default:
                return 0;
        }

    }
}
