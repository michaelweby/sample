<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/27/2018
 * Time: 8:46 PM
 */

namespace App\Http\FileUploaders;


class UserUploader implements FileUploader
{

    public function upload($data)
    {
        foreach ($data as $key => $value) {
            $arr[] = [
                'first_name'=>$value->first_name,
                'last_name'=>$value->last_name,
                'username'=>str_slug($value->username,'-'),
                'type'=>$value->type,
                'email'=>$value->email,
                'password'=>bcrypt(str_slug($value->username,'-')),
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ];
        }
        return $arr;
    }

    public function insert($data)
    {
        if(!empty($data)){
            \DB::table('users')->insert($data);
            dd('Insert Record successfully.');
        }
    }
}