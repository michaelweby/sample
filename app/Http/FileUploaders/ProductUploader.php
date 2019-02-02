<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/26/2018
 * Time: 4:38 PM
 */

namespace App\Http\FileUploaders;


class ProductUploader implements FileUploader
{
    public function upload($data)
    {
         foreach ($data as $key => $value) {
            $arr[] = ['name' => $value->name,
                'description' => $value->description,
                'serial_number'=>$value->serial_number,
                'image'=>'',
                'shop_id'=>0,
                'recommendation'=>0,
                'published'=>1,
                'priorty'=>0,
                'price'=>$value->price,
                'discount_type'=>'pound',
                'discount'=>0,
                'start'=>null,
                'end'=>null,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ];
        }
        return $arr;
    }
    public function insert($data)
    {
        if(!empty($data)){
            \DB::table('products')->insert($data);
            dd('Insert Record successfully.');
        }
    }
}