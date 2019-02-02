<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/16/2018
 * Time: 1:20 AM
 */

namespace App\Http\Controllers\Transformers;


use App\ProductItem2;

class CartTransformer extends Transformer
{

    public function transform($item)
    {
        $itemProduct = ProductItem2::where('id',$item->product_id)->first();
        $newPrice = $itemProduct->price ;
        $preparingTime = [
            'week'=>intval($itemProduct->product->preparing_days / 7),
            'days'=>$itemProduct->product->preparing_days % 7,
        ];
        if ($itemProduct->product->runningDiscount()){
            $newPrice = $itemProduct->product->discountType =='pound'?$itemProduct->price - $itemProduct->product->discount:$itemProduct->price - ($itemProduct->product->discount * $itemProduct->price)/100;
        }
        $attributes = [];
        foreach($itemProduct->attribute as $attribute){
            $attributes[$attribute->attributeName->name] = $attribute->value;
        }
       return [
           'id'=>$itemProduct->id,
           'cart_id'=>$item->id,
           'name'=>$itemProduct->product->name,
           'quantity'=>$item->quantity,
           'item_stock'=>$itemProduct->amount,
           'shop_logo'=>$itemProduct->product->shop->logo,
           'shop_title'=>$itemProduct->product->shop->title,
           'runningDiscount'=>$itemProduct->product->runningDiscount(),
           'price'=>$itemProduct->price,
           'newPrice'=>$newPrice,
           'image'=>$itemProduct->product->image,
           'preparingTime'=>$preparingTime,
           'preparingDaysRow'=>$itemProduct->product->preparing_days,
           'rate'=>(float)number_format($itemProduct->product->reviews()->avg('stars')),
           'available'=>$itemProduct->amount,
           'attributes'=>$attributes,
       ];
    }
}