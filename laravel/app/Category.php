<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $fillable=['name'];
    public function Items()
    {
        return $this->hasMany('\App\Item')->orderBy('name');
    }
}
