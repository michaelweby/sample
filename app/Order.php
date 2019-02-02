<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['status','shipping_id','shipping_value','coupon_id','total','discount'];

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function products()
    {
        return $this->belongsToMany(ProductItem2::class,'order_product','order_id','product_id')->withPivot('quantity','original_price','discount','discount_type','product_id');
    }

    public function main_product(){

    }

    public function customer(){
        return $this->belongsTo(User::class);
    }

    public function getByStatus($status){
        return $this->where('status',$status);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class);
    }

    public function total(){

    }

}
