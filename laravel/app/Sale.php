<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected  $fillable=['ordered_by','driver_id','customer_id','branch_id','plate_no','note','sale_date','total_items','status','created_by'];

    public function customer()
    {
        return $this->hasOne('\App\People','id','customer_id');
    }
    public function driver()
    {
        return $this->hasOne('\App\People','id','driver_id');
    }
    public function orderedBy()
    {
        return $this->hasOne('\App\People','id','ordered_by');
    }
    public function saleItems()
    {
        return $this->hasMany('\App\SaleItems');
    }
    public function user()
    {
        return $this->hasOne('\App\User','id','created_by');
    }
    public function FilterItem($item_id)
    {
        if($item_id!=""){
            return $this->saleItems()->where('item_id',$item_id)->get();
        }else{
            return $this->saleItems()->get();
        }

    }
    public function ItemsCount()
    {
        return $this->saleItems()->count();


    }
    public function scopeSearchSaleId($query,$sale_id)
    {
        return $query->where('id',$sale_id);
    }
    public function scopeSearchDriverId($query,$driver_id)
    {
        return $query->where('driver_id',$driver_id);
    }
    protected $dates = [
        'created_at',
        'updated_at',
        'sale_date'
    ];



}
