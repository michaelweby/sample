<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/26/2018
 * Time: 4:36 PM
 */

namespace App\Http\FileUploaders;


interface FileUploader
{
    public function upload($data);
    public function insert($data);
}