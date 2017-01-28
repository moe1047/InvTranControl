<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected  $fillable=['purchased_date','ship_name','origin_country'];


    public function purchaseItems()
    {
        return $this->hasMany('\App\PurchaseItems');
    }
    public function FilterItem($item_id)
    {
        if($item_id!=""){
            return $this->purchaseItems()->where('item_id',$item_id)->get();
        }else{
            return $this->purchaseItems()->get();
        }

    }
    public function ItemsCount()
    {
        return $this->purchaseItems()->count();


    }
    protected $dates = [
        'created_at',
        'updated_at',
        'purchased_date'
    ];
}
