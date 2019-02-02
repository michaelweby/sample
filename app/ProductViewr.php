<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductViewr extends Model
{
    protected $table = 'product_viewers';

    public function product(){
        return $this->hasMany(Product::class,'product_id','id');
    }
}
