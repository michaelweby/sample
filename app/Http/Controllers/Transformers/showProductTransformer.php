<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/22/2018
 * Time: 6:47 PM
 */

namespace App\Http\Controllers\Transformers;


use App\Product;

class showProductTransformer extends Transformer
{
    public function transform($product)
    {
        $relatedDiscount =[];
        $relatedDiscount['valuePercentage'] = 0;
        $relatedDiscount['new_price'] = 0;

        if($product->runningDiscount()){

            $relatedDiscount['valuePercentage'] =
                $product['discount_type'] == 'percentage'?
                    (integer)$product['discount']:
                    (integer)(($product['discount'])/$product['price']*100);
            $relatedDiscount['new_price'] = $product->newPrice();
        }


        $diminutions = $product['image']?file_exists($product['image'])?getimagesize($product['image']):(object)[]:(object)[];

        return[
            'id'=>$product['id'],
//            'visits'=>$product['visits'],
            'name'=>$product['name'],
            'image'=>$product['image'],
            'image_diminutions'=>$diminutions,
            'price'=>$product['price'],
            'runningDiscount'=>(boolean)$product->runningDiscount(),
            'discount'=>$relatedDiscount,
            'shop_id'=>$product->shop_id,
            'shop'=>@$product->shop->title,
            'isElite'=>$product->isElite(),
            'isFavourite'=>$product->isFavourite(),
            'quickCart'=>$product->isSingleItem(),
            'item'=>$product->singleItem(),
            'rate'=>(float)number_format($product->reviews()->avg('stars') ,2),
        ];
    }
}