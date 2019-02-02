<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/15/2018
 * Time: 4:16 AM
 */

namespace App\Http\Controllers\Transformers;


class ErrorTransformer extends Transformer
{
    public function transform($error)
    {
        return [
            'error'=>$error
        ];
    }
}