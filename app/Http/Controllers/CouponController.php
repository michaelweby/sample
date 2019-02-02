<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Coupon;
use App\Order;
use App\Product;
use App\ProductItem;
use App\ProductItem2;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.coupons.index',['title'=>'Coupons','coupons'=>Coupon::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create',
            ['title' => 'Coupons',
             'vendors'=>User::where('type','vendor')->whereHas('shop')->get(),
             'customers'=>User::where('type','customer')->get(),
             'categories'=>Category::all(),
             'products'=>Product::all(),

            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'code'=>'required|unique:coupons',
            'expire_date'=>'required',
            'discount'=>'required',
            'users_limit'=>'required ',
        ]);

        $coupon = new Coupon();
        $coupon->code= $request->code;
        $coupon->applying= $request->applying;
        $coupon->start= new Carbon($request->start_date);
        $coupon->expire= new Carbon($request->expire_date);
        $coupon->limit_user= $request->users_limit;
        $coupon->usage_number= $request->usage_number;
        $coupon->discount= $request->discount;
        $coupon->discount_type= $request->discount_type;
        $coupon->save();
        if($request->has('allowed_categories')){
            foreach ($request->allowed_categories as $category){
                $coupon->constrains()->create(['type'=>'category','type_id'=>$category,'allow'=>1]);
            }
        }
        if($request->has('disallowed_categories')){
            foreach ($request->disallowed_categories as $category){
                $coupon->constrains()->create(['type'=>'category','type_id'=>$category,'allow'=>0]);
            }
        }
        if($request->has('allowed_vendors')){
            foreach ($request->allowed_vendors as $vendor){
                $coupon->constrains()->create(['type'=>'vendor','type_id'=>$vendor,'allow'=>1]);
            }
        }
        if($request->has('disallowed_vendors')){
            foreach ($request->disallowed_vendors as $vendor){
                $coupon->constrains()->create(['type'=>'vendor','type_id'=>$vendor,'allow'=>0]);
            }
        }
        if($request->has('allowed_customers')){
            foreach ($request->allowed_customers as $customer){
                $coupon->constrains()->create(['type'=>'customer','type_id'=>$customer,'allow'=>1]);
            }
        }
        if($request->has('disallowed_customers')){
            foreach ($request->disallowed_customers as $customer){
                $coupon->constrains()->create(['type'=>'customer','type_id'=>$customer,'allow'=>0]);
            }
        }
        if($request->has('allowed_products')){
            foreach ($request->allowed_products as $product){
                $coupon->constrains()->create(['type'=>'product','type_id'=>$product,'allow'=>1]);
            }
        }
        if($request->has('allowed_products')){
            foreach ($request->allowed_products as $product){
                $coupon->constrains()->create(['type'=>'product','type_id'=>$product,'allow'=>0]);
            }
        }
        return redirect(PATH.'/coupons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        $orders = $coupon->orders()->where('status','<>','canceled')->get();
        return view('admin.coupons.show',['coupon'=>$coupon,'title'=>"Coupon {$coupon->code}" ,'orders'=>$orders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit',
            ['title' => 'Coupons',
                'coupon'=>$coupon,
                'vendors'=>User::where('type','vendor')->wherehas('shop')->get(),
                'customers'=>User::where('type','customer')->get(),
                'categories'=>Category::all(),
                'products'=>Product::all(),
                'allowed_vendors'=>$coupon->constrains()
                    ->where('type','vendor')
                    ->where('allow',1)
                    ->pluck('type_id'),
                'disallowed_vendors'=>$coupon->constrains()
                    ->where('type','vendor')
                    ->where('allow',0)
                    ->pluck('type_id'),
                'disallowed_categories'=>$coupon->constrains()
                    ->where('type','category')
                    ->where('allow',0)
                    ->pluck('type_id'),
                'allowed_categories'=>$coupon->constrains()
                    ->where('type','category')
                    ->where('allow',1)
                    ->pluck('type_id'),
                'allowed_customers'=>$coupon->constrains()
                    ->where('type','customer')
                    ->where('allow',1)
                    ->pluck('type_id'),
                'disallowed_customers'=>$coupon->constrains()
                    ->where('type','customer')
                    ->where('allow',0)
                    ->pluck('type_id'),
                'disallowed_products'=>$coupon->constrains()
                    ->where('type','product')
                    ->where('allow',0)
                    ->pluck('type_id'),
                'allowed_products'=>$coupon->constrains()
                    ->where('type','product')
                    ->where('allow',1)
                    ->pluck('type_id'),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->validate($request,[
        'code'=>'required|unique:coupons,code,'.$coupon->id,
        'expire_date'=>'required',
        'discount'=>'required',
        'users_limit'=>'required ',
        ]);
//        dd($request->all());
        $coupon->code= $request->code;
        $coupon->applying= $request->applying;
        $coupon->start= new Carbon($request->start_date);
        $coupon->expire= new Carbon($request->expire_date);
        $coupon->limit_user= $request->users_limit;
        $coupon->usage_number= $request->usage_number;
        $coupon->discount= $request->discount;
        $coupon->discount_type= $request->discount_type;
        $coupon->save();
        $coupon->constrains()->delete();
        if($request->has('allowed_categories')){
            foreach ($request->allowed_categories as $category){
                $coupon->constrains()->create(['type'=>'category','type_id'=>$category,'allow'=>1]);
            }
        }
        if($request->has('disallowed_categories')){
            foreach ($request->disallowed_categories as $category){
                $coupon->constrains()->create(['type'=>'category','type_id'=>$category,'allow'=>0]);
            }
        }
        if($request->has('allowed_vendors')){
            foreach ($request->allowed_vendors as $vendor){
                $coupon->constrains()->create(['type'=>'vendor','type_id'=>$vendor,'allow'=>1]);
            }
        }
        if($request->has('disallowed_vendors')){
            foreach ($request->disallowed_vendors as $vendor){
                $coupon->constrains()->create(['type'=>'vendor','type_id'=>$vendor,'allow'=>0]);
            }
        }
        if($request->has('allowed_customers')){
            foreach ($request->allowed_customers as $customer){
                $coupon->constrains()->create(['type'=>'customer','type_id'=>$customer,'allow'=>1]);
            }
        }
        if($request->has('disallowed_customers')){
            foreach ($request->disallowed_customers as $customer){
                $coupon->constrains()->create(['type'=>'customer','type_id'=>$customer,'allow'=>0]);
            }
        }
        if($request->has('allowed_products')){
            foreach ($request->allowed_products as $product){
                $coupon->constrains()->create(['type'=>'product','type_id'=>$product,'allow'=>1]);
            }
        }
        if($request->has('allowed_products')){
            foreach ($request->allowed_products as $product){
                $coupon->constrains()->create(['type'=>'product','type_id'=>$product,'allow'=>0]);
            }
        }
        return back();
//        return redirect(PATH.'/coupons');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->constrains()->sync([]);
        $coupon->delete();
        return redirect(PATH.'/coupons');
    }

    // search if coupon code exits
    // apply constrains
    // return total discount

    public function apply(Request $request){
        $customer =$request->customer_id;

         if($coupon = Coupon::where('code',$request->code)->first() and $customer){
            return $coupon->applyConstrains($request->itemIds,$request->amounts,$customer);
         }
         if($coupon){
             return response()->json(['error'=>'Please Enter Customer']) ;
         }else{
             return response()->json(['error'=>'Coupon Code doesn\'t exist']) ;
         }

    }
    public function applyApi(Request $request){
        $request = json_decode($request->getContent());

        $coupon = Coupon::where('code',$request->code)->first();
        if (!$coupon){
            return $this->responseNotFound('No Coupon with that code check again');
        }
        $this->check_conditions($coupon);
         $items = array_column(ProductItem2::whereIn('id',array_column((new Cart())->cartItems()->toArray(),'product_id'))->get()->toArray(),'id');
         $quantities = array_column((new Cart())->cartItems()->toArray(),'quantity');
            $response =  $coupon->applyConstrains($items,$quantities,auth()->id());
            $response =json_decode($response->content(),true);
            if (isset($response['error'])){
                return $this->responseWithError($response['error']);
            }
         return $this->responseSuccess(['discount'=>$response['discount'],'coupon_id'=>$response['coupon_id']]);

    }
    public function applyWeb(Request $request){
        $coupon = Coupon::where('code',$request->code)->first();
        if (!$coupon){
            return $this->responseNotFound('No Coupon with that code check again');
        }
        $this->check_conditions($coupon);
         $items = array_column(ProductItem2::whereIn('id',array_column((new Cart())->cartItems()->toArray(),'product_id'))->get()->toArray(),'id');
         $quantities = array_column((new Cart())->cartItems()->toArray(),'quantity');
            $response =  $coupon->applyConstrains($items,$quantities,auth()->id());
            $response =json_decode($response->content(),true);
            if (isset($response['error'])){
                return $this->responseWithError($response['error']);
            }
         return $this->responseSuccess(['discount'=>$response['discount'],'coupon_id'=>$response['coupon_id']]);

    }

    public function check_conditions(Coupon $coupon){
        if ($coupon->isExpired()<0 and $coupon->isStarted() >=0){
            return $this->responseWrongValidation('This coupon is not valid now');
        }
        if (!$coupon->overLimit()){
            return $this->responseWrongValidation('Sorry this coupon is over limit Usage');
        }
        if (!$coupon->overLimitUser(auth()->id())){
            return $this->responseWrongValidation('Sorry your usage to  this coupon is over limit');
        }
    }
}
