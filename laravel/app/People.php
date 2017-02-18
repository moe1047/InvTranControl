<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected  $fillable=['name','no','type','branch_id'];
    public function branch()
    {
        return $this->hasOne('\App\People','id','branch_id');
    }
}
