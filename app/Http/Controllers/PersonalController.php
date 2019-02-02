<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Transformers\showProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{
    public function viewPage(){
        $favourite_shops = auth()->user()->favourite_shop;
        $address = auth()->user()->shipping;
        return view('website.personal',['orders'=>auth()->user()->order,'favourite_shops'=>$favourite_shops,'address'=>$address]);
    }

    public function favorites(){
        return (new showProductTransformer())->transformCollection(auth()->user()->favourite->all());
    }

}
