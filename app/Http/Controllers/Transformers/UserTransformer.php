<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 6/15/2018
 * Time: 2:12 AM
 */

namespace App\Http\Controllers\Transformers;


class UserTransformer extends Transformer
{
    public function transform($user)
    {

        return[
            'id'=>(integer)$user['id'],
            'name'=>$user['first_name'].' '.$user['last_name'],
            'email'=>$user['email'],
            'image'=>$user['image'],
            'token'=>$user->createToken('MyApp')->accessToken,
        ];
    }
}