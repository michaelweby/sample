<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Transformers\ShopTransformer;
use App\Http\Controllers\Transformers\showProductTransformer;
use App\Product;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

class ShopController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $title='Shop';

    protected $shopTransformer;

    /**
     * ShopController constructor.
     * @param $shopTransformer
     */
    public function __construct(ShopTransformer $shopTransformer)
    {
        $this->shopTransformer = $shopTransformer;
    }

    public function index()
    {
        return view('admin.shops.index')->with(['title'=>$this->title,'shops'=>Shop::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function hasShop($vendor){
            if ($vendor->shop)
                return $vendor;
        }
    public function create()
    {
        $vendors = array();
        foreach (User::where('type','vendor')->with('shop')->get() as $vendor){
            if (!$vendor->shop)
                $vendors[]= $vendor;
        }
        return view('admin.shops.create')->with(['title'=>$this->title,'vendors'=>$vendors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {
//        dd($request->all());
        if($request->hasFile(   'logo'))
            $logo=app('help')->help($request->logo);
        else
            $logo='uploads/default.png';
        $shop = new Shop();
        $shop->title = $request->title;
        $shop->logo = $logo;
        $shop->address = $request->address;
        $shop->phone = $request->phone;
        $shop->description = $request->description;
        $shop->bank_account_number = $request->bank_account_number;
        $shop->bank_account_name = $request->bank_account_name;
        $shop->fixed = $request->fixed;
        $shop->owner_id = $request->owner_id;
        if ($request->fixed){
            $shop->commission = $request->commission_value;
        }
        $shop->save();

        return redirect(PATH.'/shops');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $products = $shop->products;
//         $orders = $shop->products()->with('items.orders')->get();
        return view('admin.shops.show',['shop'=>$shop,'title'=>'Shop']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit')->with(['title'=>$this->title,'shop'=>$shop,'vendors'=>(new User)->vendors()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(ShopRequest $request, Shop $shop)
    {

        if($request->hasFile('image')){
            $logo=app('help')->help($request->image);
            $shop->logo = $logo;
        }

        $shop->title = $request->title;
        $shop->address = $request->address;
        $shop->phone = $request->phone;
        $shop->description = $request->description;
        $shop->bank_account_number = $request->bank_account_number;
        $shop->bank_account_name = $request->bank_account_name;
        $shop->fixed = $request->fixed;
        $shop->owner_id = $request->owner_id;
        if ($request->fixed){
            $shop->commission = $request->commission_value;
        }
        $shop->save();
        return redirect(PATH.'/shop/'.$shop->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        foreach ($shop->products as $product){
            $product->shop_id = 0;
            $product->save();
        }
        $shop->delete();
        return redirect('dashboard/shops');
    }
    public function favourite($id){
        $shop = Shop::find($id);
        if (!$shop){
            return $this->responseNotFound('Shop Not found');
        }
        if($shop->favouriteBy()->where('user_id',auth()->id())->count()){
            $shop->favouriteBy()->detach(auth()->id());
            return $this->responseSuccess('remove from favourite');
        }
        $shop->favouriteBy()->attach(auth()->id());
        return $this->responseSuccess('add to favourite');
    }
    public function singleApi($id){
        $shop = Shop::find($id);
        if (!$shop){
            return $this->responseNotFound('Shop Not found');
        }
        if ( !$shop->isActive() ){
            return $this->responseNotFound('Shop Not Available Now');
        }
        $productTransformer = new showProductTransformer();
        return $this->responseSuccess([
            'shop'=>$this->shopTransformer->transform($shop),
            'products'=>$productTransformer->transformCollection($shop->products()->orderBy('created_at','desc')->take(10)->get()->all()),
        ]);

    }
    public function singleShopPaginate($shop,$page=1,$amount = 10){
        $shop = shop::find($shop);
        if(!$shop){
            return $this->responseNotFound('No Shop with that ID');
        }

        $transformer = new showProductTransformer();
        return $this->responseSuccess($transformer->transformCollection(
            Product::where('shop_id',$shop->id)->skip(--$page*$amount)->orderBy('created_at','desc')->take($amount)->get()->all()
        ));
    }

    public function siteShop(Shop $shop){
        return view('website.shop',compact('shop'));
    }

}
