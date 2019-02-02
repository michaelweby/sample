<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/19/2018
 * Time: 4:28 PM
 */

namespace App\Http\Controllers\Transformers;


class ShowOrderTransformer extends Transformer
{

    public function transform($order)
    {
        return [
            'id'=>$order->id,
            'date'=>$order->created_at->toFormattedDateString(),
        ];
    }
}