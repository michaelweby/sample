<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart extends Model
{
    // cart must be owned to a customer
    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function products(){
        return $this->hasMany(ProductItem2::class,'product_id');
    }
    // add new product to cart or increase if found
    public function addOrUpdate($product,$quantity){
        if ($stored = Cart::where('customer_id',auth()->user()->id)->where('product_id',$product)->first()){
            return 'item in cart';
//                $stored->quantity += $quantity;
//            $stored->save();
        }else{
            Cart::insert([
                'product_id'=>$product,
                'quantity'=>$quantity,
                'customer_id'=>auth()->user()->id,
            ]);
        }

    }

    // get user cart
    public function cartItems(){
        return Cart::where('customer_id',auth()->id())->get();
    }

    // count user cart items
    public static function countItems(){
        if (auth()->user()){
            return Cart::where('customer_id',auth()->id())->sum('quantity');
        }
        return 0 ;
    }
    public function total()
    {
        $total =0 ;
        foreach (Cart::where('customer_id',auth()->id())->get() as $item){
            $productItem = ProductItem2::find($item->product_id);
            if ($productItem->amount > 0)
                $total += $productItem->price * $item->quantity;
            if ($productItem->product->runningDiscount())
                $total -=
                    $productItem->product->discount_type == 'pound'?
                    $productItem->product->discount * $item->quantity:
                        (($productItem->product->discount * $productItem->price)/100)*$item->quantity ;
        }
        return $total;
    }

    // delete all cart item for user
    public function clear(){
        foreach ($this->cartItems() as $item){
            $product = ProductItem2::find($item->product_id);
            $product->amount -= $item->quantity;
            $product->save();
            $item->delete();
        }
        auth()->user()->cart()->delete();
    }

}