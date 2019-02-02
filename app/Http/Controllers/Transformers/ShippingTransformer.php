<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/7/2018
 * Time: 4:23 AM
 */

namespace App\Http\Controllers\Transformers;


class ShippingTransformer extends Transformer
{
    public function transform($shipping)
    {
        return [
          'id'=>$shipping->id,
          'first_name'=>$shipping->first_name,
          'last_name'=>$shipping->last_name,
          'email'=>$shipping->email,
          'phone'=>$shipping->phone,
          'address'=>$shipping->address,
          'apartment'=>$shipping->apartment,
          'floor'=>$shipping->floor,
          'land_mark'=>$shipping->land_mark,
        ];
    }
}