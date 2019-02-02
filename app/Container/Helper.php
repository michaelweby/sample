<?php
/**
 * Created by PhpStorm.
 * User: shenouda
 * Date: 28/05/18
 * Time: 09:36 م
 */

namespace App\Container;
use Image;

class  Helper
{
    public function help($file)
    {
        $file_name = time().'-'.mt_rand(). '.' . $file->getClientOriginalExtension();
        $pathname = 'uploads/' . date("Y") . '/' . date("m").'/'. date("d").'/';
        if (!is_dir($pathname)) {
            mkdir($pathname, 0755, true);
        }
        $img = Image::make($file)->widen(1000, function ($constraint) {
            $constraint->upsize();
        });
        $img->save(public_path($pathname).$file_name);
        return $pathname.$file_name;
    }
    public function image2($image)
    {
        $file_name = time().'-'.mt_rand(). '.' . $image->getClientOriginalExtension();
        $pathname = 'uploads/' . date("Y") . '/' . date("m").'/'. date("d").'/';
        if (!is_dir($pathname)) {
            mkdir($pathname, 0755, true);
        }
        $image->move(public_path($pathname).$file_name);
        return $pathname.$file_name;
    }
}