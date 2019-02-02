<?php

namespace App\Http\Controllers\Transformers;

class ShopTransformer extends Transformer{

    public function transform($shop)
    {
        $diminutions = $shop->logo?file_exists($shop->logo)?getimagesize($shop->logo):(object)[]:(object)[];
        return[
          'id'=>$shop->id,
          'title'=>$shop->title,
          'image'=>$shop->logo,
          'image_diminutions'=>$diminutions,
          'description'=>$shop->description,
          'elite'=>(boolean)$shop->elite,
          'favorite'=>(boolean)$shop->isFavourite(),
        ];
    }
}