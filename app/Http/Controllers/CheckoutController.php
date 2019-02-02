<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Controllers\Transformers\CartTransformer;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function show(){
        $shipping = auth()->user()->shipping;
        $cart = new Cart();
        $items = (new CartTransformer())->transformCollection($cart->cartItems()->all());
        $shipping_cost = Setting::first()->shipping_cost;
        $total = 0; $discountTotal =0;

        $prices = array_column($items,'price');
        $quantity = array_column($items,'quantity');
        $new_prices = array_column($items,'newPrice');

        for ($i =0;$i<count($items);$i++){
            $total += $prices[$i] * $quantity[$i];
            $discountTotal+= $new_prices[$i] * $quantity[$i];
        }

        $preparing = count($items)?max(array_column($items,'preparingDaysRow')):0;
        return view('website.checkout',['items'=>$items,'shipping'=>$shipping,'shipping_cost'=>$shipping_cost,'total'=>$total,'discountTotal'=>$discountTotal,'preparing'=>$preparing]);
    }

    public function checkout(Request $request){

        $discount= 0;
        if($request->has('coupon_id')){
            $discount = Coupon::find($request->coupon_id)->discount;
        }
        $order = new Order();
        $order->status = 'new';
        $order->customer_id = auth()->id();
        $order->coupon_id = $request->coupon_id;
        $order->shipping_id = $request->shiping_id;
        $order->total = (new Cart)->total() - $discount;
        $order->save();
        $items = Cart::where('customer_id',auth()->id())->get();
        foreach ($items as $item){
            $order->products()->attach($item->product_id,['quantity'=>$item->quantity]);
            $item->delete();
        }
        return $order;
    }
}
