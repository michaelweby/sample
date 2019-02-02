<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    protected $fillable=['product_id','x_translate','y_translate','image'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
