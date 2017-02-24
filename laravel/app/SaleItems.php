<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model
{
    protected  $fillable=['sale_id','qty','item_id','on_board','in_stock','item_warehouse_id'];
    protected  $table="sale_items";
    public function Item()
    {
        return $this->hasOne('\App\Item','id','item_id');
    }
    public function ItemWarehouse()
    {
        return $this->hasOne('\App\ItemWarehouse','id','item_warehouse_id');
    }
    public function Sale()
    {
        return $this->hasOne('\App\Sale','id','sale_id');
    }
    public function SaleItemTransactions()
    {
        return $this->hasMany('\App\SaleItemTran','sale_item_id','id');
    }
}
