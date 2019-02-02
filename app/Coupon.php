<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $dates=['start','expire'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function constrains()
    {
        return $this->hasMany(CouponConstraint::class);
    }
    public function isStarted()
    {
        return Carbon::now()->diffInDays($this->start, false);
    }
    public function isExpired()
    {
        return Carbon::now()->diffInDays($this->expire, false);
    }

    public function isActive(){
        if($this->isStarted() <= 0 and $this->isExpired() >=0){
            return true;
        }
        return false;
    }

    public function overLimit()
    {
        // true if not over limit
        if (Order::where('coupon_id', $this->id)->where('status', '!=', 'cancel')->count() < $this->usage_number) return true;
        else return false;
    }

    public function overLimitUser($customer_id)
    {
        // true if under limit

        if (Order::where('coupon_id', $this->id)
                ->where('status', '!=', 'cancel')
                ->where('customer_id', $customer_id)
                ->count() > $this->limit_user) return false;

        return true;
    }

    public function applyConstrains(array $items, array $amounts, $customer_id)
    {
        if($this->isStarted() > 0){
            return response()->json(['error' => 'this coupon not valid yet']);
        }
        if ($this->isExpired() < 0) {
            return response()->json(['error' => 'this coupon expired']);
        }

        if (!$this->overLimit()) {
            return response()->json(['error' => 'this coupon reached Usage limit']);
        }

        if (!$this->overLimitUser($customer_id)) {
            return response()->json(['error' => 'this user reached Usage limit for this coupon']);
        }

        $discount = 0;
        $itemsObj = ProductItem2::find($items);

        $allowed_users = $this->constrains()->where('type', 'customer')->where('allow', 1)->pluck('type_id');
        $disallowed_users = $this->constrains()->where('type', 'customer')->where('allow', 0)->pluck('type_id');
        $allowed_categories = $this->constrains()->where('type', 'category')->where('allow', 1)->pluck('type_id');
        $disallowed_categories = $this->constrains()->where('type', 'category')->where('allow', 0)->pluck('type_id');
        $allowed_vendors = $this->constrains()->where('type', 'vendor')->where('allow', 1)->pluck('type_id');
        $disallowed_vendors = $this->constrains()->where('type', 'vendor')->where('allow', 0)->pluck('type_id');
        $allowed_products = $this->constrains()->where('type', 'product')->where('allow', 1)->pluck('type_id');
        $disallowed_products = $this->constrains()->where('type', 'product')->where('allow', 0)->pluck('type_id');


        if (in_array($customer_id, json_decode($disallowed_users, true))) {
            return response()->json(['error' => 'This customer is expanded to use that coupon, please use anther coupon']);
        }

        // if customer is allowed or there are not allowed customer apply for all
        elseif (in_array($customer_id, json_decode($allowed_users, true)) or count(json_decode($allowed_users, true)) == 0) {

            $total = 0;
            foreach ($itemsObj as $index => $item) {

                if ($this->discount_type == 'pound') {
                    $coupon_discount = $this->discount;
                } else {
                    $coupon_discount = $this->discount * $item->price / 100;
                }

                if (// check coupon constrains
                    in_array($item->product_id, json_decode($allowed_products, true))
                    or !empty(array_intersect(json_decode($item->product->categories->pluck('id'), true), json_decode($allowed_categories, true)))
                    or in_array($item->product->shop->owner_id, json_decode($allowed_vendors, true))
                    or in_array($item->product_id, json_decode($disallowed_products, true))
                    or !empty(array_intersect(json_decode($item->product->categories->pluck('id'), true), json_decode($disallowed_categories, true)))
                    or in_array($item->product->shop->owner_id, json_decode($disallowed_vendors, true))
                    or count($this->constrains) == 0
                ) {
                    if ($this->applying == 'per_product') {
                        $discount += $coupon_discount * $amounts[$index];
                    }else{
                        $total += $item->price * $amounts[$index] ;
                    }

                }
            }

            if ($this->applying == 'for_cart'){
                if ($this->discount_type == 'pound') {
                    $discount =  $this->discount;
                }
                else{
                    $discount = (new Cart)->total() * $this->discount / 100;
                }

            }

            return response()->json(['discount' => $discount, 'coupon_id' => $this->id]);
        }
    }
}
