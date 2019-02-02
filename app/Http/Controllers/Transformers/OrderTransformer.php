<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/19/2018
 * Time: 5:12 PM
 */

namespace App\Http\Controllers\Transformers;


use App\Coupon;
use App\Product;
use Carbon\Carbon;

class OrderTransformer extends Transformer
{

    public function transform($order)
    {
        $products = [];
        foreach ($order->products as $product) {

         $main_product  = Product::find($product->product_id);
         $preparing = [];
            $preparingDiff = $main_product->preparing_days*24 - $order->created_at->diffInHours(Carbon::now());
            $preparing['totalDiffInHours'] = 0;
            $preparing['weeks'] = 0;
            $preparing['days'] = 0;
            $preparing['hours'] = 0;
          if ( $preparingDiff > 0){
              $preparing['totalDiffInHours'] = $preparingDiff;
              $preparing['weeks'] = floor($preparingDiff / (7*24));
              $preparing['days'] = floor($preparingDiff / 24 -$preparing['weeks']*7);
              $preparing['hours'] = $preparingDiff % 24;
          }
         $products [] =[
            'id'=>$main_product->id,
            'name'=>$main_product->name,
            'item_id'=>$product->id,
            'image'=>$main_product->image,
            'price'=>$product->pivot->original_price,
            'discount'=>$product->pivot->discount,
            'discount_type'=>$product->pivot->discount_type,
            'quantity'=>$product->pivot->quantity,
            'preparing'=>$preparing,
            'shop_id'=>$main_product->shop->id,
            'shop_name'=>$main_product->shop->title,
            'shop_logo'=>$main_product->shop->logo,
         ];

        }
        $shipping = [
            'first_name'=>$order->shipping->first_name,
            'last_name'=>$order->shipping->last_name,
            'email'=>$order->shipping->email,
            'address'=>$order->shipping->address,
            'phone'=>$order->shipping->phone,
            'floor'=>$order->shipping->floor,
            'apartment'=>$order->shipping->apartment,
            'land_mark'=>$order->shipping->land_mark,
        ];
        return[
            'id'=>$order->id,
            'status'=>$order->status,
            'shipping_value'=>$order->shipping_value,
            'shipping_info'=>$shipping,
            'coupon'=>$order->coupon_id,
            'coupon_code'=>$order->coupon_id?Coupon::find($order->coupon_id)->code:null,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'date'=>$order->created_at->toFormattedDateString(),
            'products'=>$products,
        ];
    }
}