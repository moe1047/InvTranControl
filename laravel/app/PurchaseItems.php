<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    protected  $fillable=['item_id','qty','purchase_id','item_warehouse_id'];
    protected  $table="purchase_items";
    public function ItemWarehouse()
    {
        return $this->hasOne('\App\ItemWarehouse','id','item_warehouse_id');
    }
    public function Item()
    {
        return $this->hasOne('\App\Item','id','item_id');
    }
    public function Purchase()
    {
        return $this->hasOne('\App\Purchase','purchase_id','id');
    }

}
