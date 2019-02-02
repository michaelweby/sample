<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/21/2018
 * Time: 8:18 PM
 */

namespace App\Http\Controllers\Transformers;


use App\User;

class ReviewTransformer extends Transformer
{

    public function transform($review)
    {
        return [
            'id'=>$review->id,
            'stars'=>(integer)$review->stars,
            'body'=>$review->review,
            'user'=>[
                'name'=>@$review->user->first_name.' '.@$review->user->last_name,
                'image'=>@$review->user->image,
            ],
        ];
    }
}