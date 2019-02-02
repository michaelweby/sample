<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItem2 extends Model
{
    protected $table = 'product_items';

    protected $fillable=['quantity','original_price','discount','discount_type'];

    public function attribute()
    {
        return $this->belongsToMany(AttributeValue::class,'product_groups','item_id','attribute_id')->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function shop(){
        return $this->hasManyThrough(Shop::class,Product::class,'id','id');
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_product','order_id')->withPivot('product_id');
    }
    public function itemAttributes(){
        return $this->hasManyThrough(AttributeValue::class,Attribute::class,'id','id');
    }
}
