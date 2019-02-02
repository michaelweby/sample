<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/14/2018
 * Time: 9:12 PM
 */

namespace App\Http\Controllers\Transformers;


abstract class Transformer
{
    public function transformCollection(array $items){

        return array_map([$this,'transform'],$items);

    }
    public abstract function transform($item);
    }