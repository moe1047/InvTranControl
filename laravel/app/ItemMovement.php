<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMovement extends Model
{
    protected  $table="item_movements";
    protected  $fillable=['tran_type','tran_type_id','qty','in_stock','item_id','item_warehouse_id'];
    public function sale()
    {
        return $this->hasOne('\App\Sale','id','tran_type_id');
    }
    public function saleExists($id)
    {
        if(Sale::where('id',$id)->get()->count()>0){
            return true;
        }else{
            return false;
        }
    }
}
