<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponConstraint extends Model
{
    protected $fillable = ['type','type_id','allow'];
    public  function coupon(){
        return $this->belongsTo(Coupon::class);
    }
}
