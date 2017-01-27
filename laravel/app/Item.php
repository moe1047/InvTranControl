<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected  $fillable=['name','qty','alert_qty','category_id'];
    public function SaleItems()
    {
        return $this->hasMany('\App\SaleItems','item_id','id');
    }
    public function Category()
    {
        return $this->hasOne('\App\Category','id','category_id');
    }
    public function getPending()
    {
        $pendings=$this->saleItems()->where('in_stock','>',0)->get();
        $total_pending=0;
        foreach($pendings as $pending){
            $total_pending+=$pending->in_stock;
        }
        return $total_pending;
    }

}
