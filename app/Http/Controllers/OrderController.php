<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Coupon;
use App\Http\Controllers\Transformers\ConfirmationTransformer;
use App\Http\Controllers\Transformers\OrderTransformer;
use App\Http\Controllers\Transformers\ShowOrderTransformer;
use App\Order;
use App\Setting;
use App\Product;
use App\ProductItem2;
use App\Shipping;
use App\User;
use App\Mail\OrderNotify;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders['pending'] = Order::where('status','pending')->paginate(15);
        $orders['on_hold'] = Order::where('status','on_hold')->paginate(15);
        $orders['completed'] = Order::where('status','completed')->paginate(15);
        $orders['canceled'] = Order::where('status','canceled')->paginate(15);
        $orders['refunded'] = Order::where('status','refunded')->paginate(15);
        $orders['processing'] = Order::where('status','processing')->paginate(15);
        return view('admin.orders.index',['title'=>'Orders','orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.orders.create',['title'=>'Orders','products'=>Product::all(),'customers'=>User::where('type','customer')->get(),'shipping_cost'=>Setting::first()->shipping_cost,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(count($request->item_id)==0){
            return back()->withErrors('No Product in that Order !!');;
        }
        $order = new Order();
        if($request->shipping_id == 0){
            $shipping = new Shipping();
            $shipping->address = $request->shipping_address;
            $shipping->phone = $request->shipping_phone;
            $shipping->email = $request->shipping_email;
            $shipping->first_name = $request->shipping_first_name;
            $shipping->last_name = $request->shipping_last_name;
            $shipping->user_id = $request->customer_id;
            $shipping->save();
            $order->shipping_id = $shipping->id;
        }else{
            $order->shipping_id = $request->shipping_id;
        }
        $order->status = $request->status;
        $order->shipping_value = $request->shipping_value;
        $order->coupon_id = $request->coupon_id;
        $order->customer_id = $request->customer_id;
        $order->total = $request->final_total;
        $order->discount = $request->discount;
        $order->save();

        $i=0;
        $vendors = array();
        foreach ($request->item_id as $item){
            $itemObj = ProductItem2::find($item);
            $discount= 0;
            $discount_type= 'no_type';
//            dd(Carbon::now()->diffInDays($itemObj->product->start,false) .' '.Carbon::now()->diffInDays($itemObj->product->end,false));
            if($itemObj->product->discount
                and Carbon::now()->diffInDays($itemObj->product->start,false) <= 0
                and Carbon::now()->diffInDays($itemObj->product->end,false) >=0
            ){
                $discount = $itemObj->product->discount;
                $discount_type = $itemObj->product->discount_type;
            }
            $order->products()->attach($item,
                ['quantity'=>$request->item_amount[$i],
                 'original_price'=>$itemObj->price,
                 'discount'=>$discount,
                 'discount_type'=>$discount_type,
                ]);
            $itemObj->amount -=$request->item_amount[$i];
            $itemObj->save();
            $i++;
        }
        //get vendors emails
        foreach ($main = $order->products as $item){    //get every shop from product
            foreach ($item->shop as $shop){
                $vendors[] = User::find($shop->owner_id)->email; // get vendor email
            }
        }

        $vendors = array_unique($vendors);
        //sending emails to vendors

        foreach ($vendors as $vendor){
            \Mail::to($vendor)->send(new OrderNotify());
        }

        // sending emails to customer
        \Mail::to($shipping->email)->send(new OrderNotify());

        // sending emails to admin


        return redirect(PATH.'/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $Order)
    {
        return view('admin.orders.show',['title'=>'Orders','data'=>$Order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $Order)
    {
        return view('admin.orders.edit',['title'=>'Orders','order'=>$Order,'products'=>Product::all(),'customers'=>User::where('type','customer')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $Order)
    {

        if(count($request->item_id)==0){
            return back()->withErrors('No Product in that Order !!');
        }
        if($request->shipping_id == 0){
            $shipping = new Shipping();
            $shipping->address = $request->shipping_address;
            $shipping->phone = $request->shipping_phone;
            $shipping->email = $request->shipping_email;
            $shipping->first_name = $request->shipping_first_name;
            $shipping->last_name = $request->shipping_last_name;
            $shipping->user_id = $request->customer_id;
            $shipping->save();
            $Order->shipping_id = $shipping->id;
        }else{
            $Order->shipping_id = $request->shipping_id;
        }
        $Order->status = $request->status;
        $Order->shipping_value = $request->shipping_value;
        $Order->coupon_id = $request->coupon_id;
        $Order->customer_id = $request->customer_id;
        $Order->total = $request->final_total;
        $Order->discount = $request->discount;
        $Order->save();

        $i=0;
        $vendors = array();
        $items = array();
        foreach ($request->item_id as $item){
            $itemObj = ProductItem2::find($item);
            $discount= 0;
            $discount_type= 'no_type';
//            dd(Carbon::now()->diffInDays($itemObj->product->start,false) .' '.Carbon::now()->diffInDays($itemObj->product->end,false));
            if($itemObj->product->discount
                and Carbon::now()->diffInDays($itemObj->product->start,false) <= 0
                and Carbon::now()->diffInDays($itemObj->product->end,false) >=0
            ){
                $discount = $itemObj->product->discount;
                $discount_type = $itemObj->product->discount_type;
            }
            $items[$item] = array();
            $items[$item]['quantity'] = $request->item_amount[$i];
            $items[$item]['original_price'] = $itemObj->price;
            $items[$item]['discount'] = $discount;
            $items[$item]['discount_type'] = $discount_type;
            $itemObj->amount -=$request->item_amount[$i];
            $itemObj->save();
            $i++;
        }
//        dd($items);
        $Order->products()->sync($items);
        //get vendors emails
        foreach ($main = $Order->products as $item){    //get every shop from product
            foreach ($item->shop as $shop){
                $vendors[] = User::find($shop->owner_id)->email; // get vendor email
            }
        }

        $vendors = array_unique($vendors);
        //sending emails to vendors

//        foreach ($vendors as $vendor){
//            \Mail::to($vendor)->send(new OrderNotify());
//        }

        // sending emails to customer
//        \Mail::to($shipping->email)->send(new OrderNotify());

        // sending email s to admin


        return redirect(PATH.'/orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $Order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $Order)
    {
//        $Order->products()->sync([]);
//        $Order->delete();
//        return redirect(PATH.'/orders');

    }


    public function confirm(Request $request){
        $request = json_decode($request->getContent());
        $coupon = null;
        $shipping = Shipping::find($request->shipping_id);
        if(!$shipping){
            return $this->responseNotFound('this shipping address Not exits');
        }
        if ($shipping->user_id == auth()->id()){
            $this->responseWithError('the shipping you sent not yours');
        }
        if ($request->coupon_id != -1){
            $coupon = Coupon::find($request->coupon_id);
            if(!$coupon){
                return $this->responseNotFound('this Coupon Not exits');
            }
            (new CouponController)->check_conditions($coupon);
        }

        $discount = $request->discount;
        $transformer = new ConfirmationTransformer($shipping,$coupon,$discount);
        return $this->responseSuccess($transformer->transform());
    }


    public function order(Request $requestRow){
        $request = json_decode($requestRow->getContent());
        $shipping_value = Setting::first();
        $coupon = Coupon::find($request->coupon_id);
        $appliedCoupon = (new CouponController())->applyApi($requestRow);
        $discount=0;
        if($appliedCoupon->getData('status')['status'] != 'error'){
            $discount =((new CouponController())->applyApi($requestRow))->getData('status')['data']['discount'];

        }
        $coupon_id = $discount == 0 ? 0 :$coupon->id;
        $cart = new Cart();
        if ($cart->countItems() > 0) {
            $order = auth()->user()->order()->create([
                'status' => 'pending',
                'shipping_id' => $request->shipping_id,
                'shipping_value' => $shipping_value->shipping_cost,
                'coupon_id' => $coupon_id,
                'total' => $cart->total(),
                'discount' => $discount,
            ]);
            if ($order) {
                foreach ($cart->cartItems() as $item){
                    $product_item = ProductItem2::find($item->product_id);
                    $orderItem = [
                        'product_id'=>$item->product_id,
                        'order_id'=>$order->id,
                        'quantity'=>$item->quantity,
                        'original_price'=>$product_item->price,
                    ];
                    $main_product = $product_item->product;
                    if ($main_product->runningDiscount()){
                       $orderItem['discount'] = $main_product->discount;
                       $orderItem['discount_type'] = $main_product->discount_type;
                    }
                    DB::table('order_product')->insert($orderItem);
                }
                $cart->clear();
                return $this->responseSuccess("Order placed Successfully with id : $order->id");
            }
        }
        return $this->responseNotFound('no Product in the cart');
    }

    public function orderWebsite(Request $request){

        $shipping_value = Setting::first();
        $coupon = Coupon::find($request->coupon_id);
        $appliedCoupon = '';
        $coupon_id = null;
        $discount=0;
        if($coupon){
            $appliedCoupon = (new CouponController())->applyWeb($request);
            if($appliedCoupon->getData('status')['status'] != 'error'){
                $discount =((new CouponController())->applyWeb($request))->getData('status')['data']['discount'];
            }
            $coupon_id = $discount == 0 ? 0 :$coupon->id;
        }

        $cart = new Cart();
        if ($cart->countItems() > 0) {
            $order = auth()->user()->order()->create([
                'status' => 'pending',
                'shipping_id' => $request->shipping_id,
                'shipping_value' => $shipping_value->shipping_cost,
                'coupon_id' => $coupon_id,
                'total' => $cart->total(),
                'discount' => $discount,
            ]);

            if ($order) {
                foreach ($cart->cartItems() as $item){
                    $product_item = ProductItem2::find($item->product_id);
                    $orderItem = [
                        'product_id'=>$item->product_id,
                        'order_id'=>$order->id,
                        'quantity'=>$item->quantity,
                        'original_price'=>$product_item->price,
                    ];
                    $main_product = $product_item->product;
                    if ($main_product->runningDiscount()){
                        $orderItem['discount'] = $main_product->discount;
                        $orderItem['discount_type'] = $main_product->discount_type;
                    }
                    DB::table('order_product')->insert($orderItem);
                }
                $cart->clear();
                return view('website.order_done',compact('order'));
            }
        }

        return redirect('cart');
    }

    public function finishedOrder(){
        return view('website.order_done');
    }

    public function userOrders(){
        $orders = auth()->user()->order()->orderBy('created_at','desc')->get()->all();
        return $this->responseSuccess((new ShowOrderTransformer())->transformCollection($orders));
    }
    public function followOrders(){
        $orders = auth()->user()->order()->whereIn('status',['pending','processing'])->orderBy('created_at','desc')->get()->all();
        return $this->responseSuccess((new ShowOrderTransformer())->transformCollection($orders));
    }
    public function orderDetails($order){
        $order = Order::find($order);
        if (!$order or $order->customer_id != auth()->id()){
            return $this->responseNotFound('sorry no order with this id or no access to that user');
        }
        return $this->responseSuccess((new OrderTransformer())->transform($order));
    }
}
