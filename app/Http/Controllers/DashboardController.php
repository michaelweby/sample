<?php

namespace App\Http\Controllers;

use App\Order;
use App\ProductItem2;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function main(){
        $orders = Order::whereStatus('pending')->orderBy('created_at','desc')->get();
        $out_of_stock = ProductItem2::where('amount',[0,'null',''])->get();
        return view('admin.dashboard',['title'=> 'Dashboard','orders'=>$orders,'out_of_stock'=>$out_of_stock] );
    }
}
