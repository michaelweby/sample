<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function shops(Request $request){
        $string = $request->search;
        $shops = Shop::where('title','like',"%$request->search%")->orwhereHas('owner',function ($q) use ($string){
            $q->where('first_name','like',"%$string%");
            $q->orwhere('last_name','like',"%$string%");
        })->get();
        return view('admin.shops.search_result',['title'=>'Shops Search Result','shops'=>$shops]);
    }

    public function coupons(Request $request){
        $coupons = Coupon::where('code','like',"%$request->search%")->get();
        return view('admin.coupons.search_result',['title'=>'Coupons Search Result','coupons'=>$coupons]);
    }
    public function products(Request $request){
        $products = Product::where('name','like',"%$request->search%")->get();
        return view('admin.products.search_result',['title'=>'Proudcts Search Result','products'=>$products]);
    }

    public function users(Request $request){
//        dd($request->all());
        $users = User::where('type',$request->type)
            ->where('first_name','like',"%$request->search%")
            ->orwhere('last_name','like',"%$request->search%")
            ->get();
        return view('admin.users.search_result',['title'=>'Users Search Result','users'=>$users,'type'=>$request->type]);
    }
}
