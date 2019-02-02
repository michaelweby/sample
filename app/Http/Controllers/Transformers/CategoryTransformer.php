<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/23/2018
 * Time: 2:23 AM
 */

namespace App\Http\Controllers\Transformers;


class CategoryTransformer extends Transformer
{
    public function transform($category)
    {
           return[
               'id'=>$category->id,
               'name'=>$category->name,
               'icon'=>$category->image,
               'description'=>$category->description,
               'elite'=>(boolean) $category->elite,
           ];
    }
}