<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleItemTran extends Model
{
    protected  $fillable=['sale_item_id','in_stock','on_board','driver_id','plate_no','note'];
    protected  $table="sale_items_transactions";
    public function driver()
    {
        return $this->hasOne('\App\People','id','driver_id');
    }

}
