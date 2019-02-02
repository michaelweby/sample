<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Controllers\Transformers\CartTransformer;
use App\Order;
use App\Product;
use App\ProductItem2;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends ApiController
{
    //add product to cart
    public function add( $product,$quantity = 1){
        $item = ProductItem2::find($product);
        if(!$item){
            return $this->responseNotFound('can\'t find your product');
        }

        $cart = new Cart;
        if(auth()->user()->cart()->where('product_id',$product)->count()){
            return $this->responseSuccess('already in cart');
        }
        $cart->addOrUpdate($product,$quantity);
        return $this->responseSuccess('Product added to cart');
    }

    public function editItem($product,$quantity){
        if ($quantity<=0){
            return $this->responseWrongValidation('Quantity can\'t be negative');
        }
        $item = auth()->user()->cart()->where('product_id',$product)->first();
        if (!$item){
            return $this->responseNotFound('this product is not in the cart');
        }
        $item->quantity = $quantity;
        $item->save();
        return $this->responseSuccess('Item edited successfully');
    }

    public function cartItems(){
        return view('website.cart',['items'=>(new Cart)->cartItems()]) ;
    }
    public function update(Request $request){
       if(count($request->cart_row)>0){
           for ($i = 0; $i < count($request->cart_row) ; $i++){
               $row = Cart::find($request->cart_row[$i]);
               if ( $request->cart_item[$i] == 0 ){
                   $row->delete();
               }else{
                   $row->quantity =  $request->cart_item[$i];
                   $row->save();
               }

           }

       }
    }

    public function delete(Cart $cart){
        $cart->delete();
    }
    public function countCart(){
        return (new Cart)->countItems();
    }

    // user checkout

    public function deleteItem(Request $request){
        $request = json_decode($request->getContent());
        $delete =  auth()->user()->cart()->where('product_id',$request->product_id)->delete();
        if($delete)
            return $this->responseSuccess('Deleted from cart');
        return $this->responseWithError('can\'t deleted from cart');
    }
    public function ajaxDeleteItem(Request $request){
        $delete =  auth()->user()->cart()->where('product_id',$request->product_id)->delete();
        if($delete)
            return $this->responseSuccess('Deleted from cart');
        return $this->responseWithError('can\'t deleted from cart');
    }
    public function showItems(){
            $cart = new Cart();
            $shipping =Setting::first()->shipping_cost;
            $total =$cart->total();
           return $this->responseSuccess(
            [
                'items'=>(new CartTransformer())->transformCollection($cart->cartItems()->all()),
                'total'=>$cart->total(),
                'shippingFees'=>$shipping,
                'totalFees'=>$shipping + $total,
            ]
           );
    }


    public function webCart(){

        $cart = new Cart();
        $items = (new CartTransformer())->transformCollection($cart->cartItems()->all());
        $shipping = Setting::first()->shipping_cost;
        $total = 0; $discountTotal =0;

        $prices = array_column($items,'price');
        $quantity = array_column($items,'quantity');
        $new_prices = array_column($items,'newPrice');

        for ($i =0;$i<count($items);$i++){
            $total += $prices[$i] * $quantity[$i];
            $discountTotal+= $new_prices[$i] * $quantity[$i];
        }

        $preparing = count($items)?max(array_column($items,'preparingDaysRow')):0;
        return view('website.cart',['items'=>$items,'shipping'=>$shipping,'total'=>$total,'discountTotal'=>$discountTotal,'preparing'=>$preparing]);
    }
}
