<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Attribute;
use App\AttributeValue;
use App\Category;
use App\Http\Controllers\Transformers\ProductTransformer;
use App\Http\Controllers\Transformers\ReviewTransformer;
use App\Http\Controllers\Transformers\ShopTransformer;
use App\Http\Controllers\Transformers\showProductTransformer;
use App\Http\Requests\ProductRequest;
use App\Order;
use App\Product;
use App\ProductCategory;
use App\ProductGroup;
use App\ProductImage;
use App\ProductItem2;
use App\Shop;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ProductItemRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PHPUnit\Framework\Constraint\AttributeTest;


class ProductController extends ApiController
{


    protected $productTransformer;
    protected $showProductTransformer;

    /**
     * ProductController constructor.
     * @param $productTransformer
     * @param $showProductTransformer
     */
    public function __construct(ProductTransformer $productTransformer,showProductTransformer $showProductTransformer)
    {
        $this->productTransformer = $productTransformer;
        $this->showProductTransformer = $showProductTransformer;
    }

    /**
     * ProductController constructor.
     * @param $productTransformer
     */



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::paginate(15);
        return view('admin.products.index',['title'=>'Product','products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::all();
        return view('admin.products.form',['title'=>'Product','shops'=>$shops,'blade'=>'create','tags'=>Tag::all(),'categories'=>(new  Category)->tree()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
       $product=new Product();
       $product->name=$request->name;
       $product->description=$request->description;
       $product->serial_number=$request->serial_number;
       $product->shop_id=$request->shop_id;
       $product->priorty=$request->priority;
       $product->price=$request->price;
       $product->discount=$request->discount;

       $product->discount_type=$request->discount_type;
       $product->preparing_days=$request->preparing_days;

        $product->start=new Carbon($request->start);
       $product->end= new Carbon($request->end);
       $product->visits= $request->visits;
       $product->image = app('help')->help($request->image);

       if($request->has('recommendation'))
           $product->recommendation=1;
       else
           $product->recommendation=0;
        if($request->has('published'))
            $product->published=1;
        else
            $product->published=0;
        $product->save();

        foreach (explode(',',$request->tag) as $tag){
            $product->tags()->attach((new Tag)->sorted($tag));
        }
        if(isset($request->photos)) {
            foreach ($request->photos as $photo) {
                $product_photo=new ProductImage();
                $product_photo->image = app('help')->help($photo);
                $product_photo->product_id=$product->id;
                $product_photo->save();
            }
        }
        if(isset($request->category)) {
            $product->categories()->attach($request->category);
        }

        if(isset($request->price1)  && isset($request->count)) {
            foreach ($request->price1 as $key => $value) {
                if (isset($request->count[$key])) {
                    $item = new ProductItem2();
                    $item->product_id = $product->id;
                    $item->price = $value;
                    $item->amount = $request->count[$key];
                    if (isset($request->images[$key])) {
                        $item->image = app('help')->help($request->images[$key]);
                    }
                    else
                        $item->image = 'uploads/default.png';
                    $item->save();
//                    dd($request->attrval[$key]);
                    if(isset($request->attrval[$key]))
                    {
                        foreach ($request->attrval[$key] as $attr)
                        {
                            if($attr!=0) {
                                $attribute = new ProductGroup();
                                $attribute->attribute_id = $attr;
                                $attribute->item_id = $item->id;
                                $attribute->save();
                            }
                        }
                    }

                }
            }
        }
        return redirect(PATH.'/product');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        $to_relate = Product::orWhere('id','<>',$product->id)->whereNotIn('id',$product->related()->pluck('id')->toArray())->get();
        return view('admin.products.show',['title'=>'Product','data'=>$product,'to_relate'=>$to_relate]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $tags = implode(",", $product->tags->pluck('name')->toArray());
        return view('admin.products.form',['title'=>'Product','product'=>$product,'blade'=>'edit','categories'=>(new  Category)->tree(),'tags'=>$tags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
//        dd($request->all());
        $product->name=$request->name;
        $product->description=$request->description;
        $product->serial_number=$request->serial_number;
        $product->price=$request->price;
        $product->discount=$request->discount;
        $product->discount_type=$request->discount_type;
        $product->preparing_days=$request->preparing_days;
        if (!$request->start or !$request->end){
            $product->start=null;
            $product->end=null;
        }else{
            $product->start= new Carbon($request->start);
            $product->end= new Carbon($request->end);
        }

        $product->shop_id=$request->shop_id;
        $product->visits=$request->visits;
        $product->priorty=$request->priorty;
        if($request->has('recommendation'))
            $product->recommendation=1;
        else
            $product->recommendation=0;
        if($request->has('published'))
            $product->published=1;
        else
            $product->published=0;
        if($request->hasFile('image')) {
            @unlink($product->image);
            $product->image = app('help')->help($request->image);
        }
        $product->save();
        if(isset($request->photos)) {
            foreach ($request->photos as $photo) {
                $product_photo=new ProductImage();
                $product_photo->image = app('help')->help($photo);
                $product_photo->product_id=$product->id;
                $product_photo->save();
            }
        }
       $product->categories()->sync($request->category);
        $product->tags()->sync($request->tag_id);
//        $tags = array();
//        foreach (explode(',',$request->tag) as $tag){
//            $tags[] = (new Tag)->sorted($tag)->id;
//            $product->tags()->sync($tags);
//        }
        return redirect(PATH.'/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        foreach (ProductItem2::where('product_id',$product->id)->get() as $row) {
            if($row)
            {
                if($row->image!='default.png')
                    @unlink($row->image);
                ProductGroup::where('item_id',$row->id)->delete();
                $row->delete();
            }
        }
        if($product->image!='default.png')
            @unlink($product->image);
        $product->delete();

        return redirect(PATH.'/product');
    }

    public function additem(ProductItemRequest $request,$id)
    {
        $item = new ProductItem2();
        $item->product_id = $id;
        $item->price = $request->price;
        $item->amount = $request->amount;
        if ($request->has('image')) {
            $item->image = app('help')->help($request->image);
        }
        else
            $item->image = 'uploads/default.png';
        $item->save();

        if(isset($request->attrval))
        {
            foreach ($request->attrval as $attr)
            {
                if($attr!=0) {

                    $attribute = new ProductGroup();
                    $attribute->attribute_id = $attr;
                    $attribute->item_id = $item->id;

                    $attribute->save();
                }
            }

        }
        return back();
    }

    public function showitem(ProductItem2 $item2)
    {
        return view('admin.products.showitem',['data'=>$item2,'product'=>$item2->product,'title'=>'Item']);
    }

    public function addattribute(Request $request,$id)
    {
        if(isset($request->attrval)) {
            foreach ($request->attrval as $row) {
                $attribute = new ProductGroup();
                $attribute->item_id = $id;
                $attribute->attribute_id = $row;
                $attribute->save();
            }
        }
        return back();
    }

    public function deleteattribute(Request $request,$id)
    {
        ProductGroup::where('attribute_id',$request->attr)->where('item_id',$id)->delete();
        return back();
    }

    public function edititem(ProductItemRequest $request,ProductItem2 $item2)
    {
        $item2->price=$request->price;
        $item2->amount=$request->amount;
        if($request->hasFile('image')) {
            @unlink($item2->image);
            $item2->image = app('help')->help($request->image);
        }
        $item2->save();
        return back();
    }
    public function getItems(Product $product){
        return view('admin.ajax.select',['options'=>$product->items]) ;
    }
    public function getItem(ProductItem2 $product_item){
        return view('admin.ajax.item',['item'=>$product_item]);
    }

    public function delete_image(Request $request,ProductImage $image)
    {
        $image=ProductImage::find($request->id);
        if($image)
        {
            @unlink($image->image);
            $image->delete();
        }
        return 'true';
    }
    public function deleteitem(ProductItem2 $item2)
    {
        if($item2)
        {
            if($item2->image!='default.png')
            @unlink($item2->image);
            ProductGroup::where('item_id',$item2->id)->delete();
            $item2->delete();
        }
        return back();
    }

    public function favourite($id){
        $product = Product::find($id);
        if (!$product){
            return $this->responseNotFound('Product Not found');
        }
        if($product->favouriteBy()->where('user_id',auth()->id())->count()){
            $product->favouriteBy()->detach(auth()->id());
            return $this->responseSuccess('remove from favourite');
        }
        $product->favouriteBy()->attach(auth()->id());
        return $this->responseSuccess('add to favourite');
    }

    public function paginate($page=1,$amount=10,Request $request){
        $request = json_decode($request->getContent(),true);
        $products = Product::orderBy('visits','desc')->whereNotIn('id',$request['avoid'])->isActiveShop()->inStock()->skip(--$page*$amount)->take($amount)->get();
        return $this->showProductTransformer->transformCollection($products->all());
    }
    public function homePaginate($page=1,$amount=10,Request $request){
        $query = Product::orderBy('visits','desc')->offset(--$request->page*$amount)->limit($amount);
        if($request->has('avoid')){
            $query->whereNotIn('id',$request->avoid);
        }
        $products = $query->get();
        return $this->showProductTransformer->transformCollection($products->all());
    }

    public function showApi($product){
        $product = Product::with('items.attribute.attributeName','tags','categories')->find($product);
        if(!$product){
            return $this->responseNotFound('this Product Not found ');
        }

        if(!$product->viewed(\Request::ip(),auth()->id())){
            $product->increment('visits');
        }
        return $this->responseSuccess($this->productTransformer->transform($product));
    }

    public function siteProduct(Product $product){
        if(\request()->has('ad') && \request()->input('ad') == true){
            Ad::where('product_id',$product->id)->increment('clicks');
            return redirect("product/{$product->id}");
        }
        $attributes =[];
        foreach ($product->items as $item) {

            foreach ($item->attribute as $attr) {
                $attrObj = Attribute::find($attr['attribute_id']);
                $attributes[$attrObj->name][$attr['id']]  = $attr['value'];
                $attributes[$attrObj->name] = array_unique($attributes[$attrObj->name]);
            }
        }
        $items = [];
        foreach ($product->items as $item){
            $singleItem['id'] = $item->id;
            $singleItem['image'] = $item->image;
            $singleItem['stock'] = $item->amount;
            $singleItem['price'] = $item->price;
            $singleItem['attributes'] = [];
            foreach ( $item->attribute as $attr){
                array_push($singleItem['attributes'], [
                    'id'=>$attr->id,
                    'attribute_name'=>Attribute::find($attr->attribute_id)->name,
                    'attribute_value'=>$attr->value,

                ]);
            }
            $items[]=$singleItem;
        }
        $stars = number_format($product->reviews()->avg('stars'),1);
        if(!$product->viewed(\Request::ip(),auth()->id())){
            $product->increment('visits');
        }
        $review = $product->have_review();

        return view('website.product',compact('product','attributes','items','stars','review'));
    }
    public function productItems(Product $product){
        $items = [];
        foreach ($product->items as $item){
            $singleItem['id'] = $item->id;
            $singleItem['image'] = $item->image;
            $singleItem['stock'] = $item->amount;
            $singleItem['price'] = $item->price;
            $singleItem['runningDiscount'] = $product->runningDiscount();
            $singleItem['discount'] = $product->discount;
            $singleItem['discount_type'] = $product->discount_type;
            $singleItem['attributes'] = [];
            foreach ( $item->attribute as $attr){
                array_push($singleItem['attributes'], [
                    'id'=>$attr->id,
                    'attribute_name'=>Attribute::find($attr->attribute_id)->name,
                    'attribute_value'=>$attr->value,

                ]);
            }
            $items[]=$singleItem;
        }
        return response()->json($items);
    }

    public function unrelated(Product $product,$unrelated){
        $product->related()->detach($unrelated);
        return response()->json(true);
    }

    public function related(Product $product,Request $request){
        $product->related()->attach($request->relate);
        return back();
    }

    public function singleProductPaginate(Product $product,$page=1,$amount = 10){
       $transformer = new showProductTransformer();
       return $this->responseSuccess($transformer->transformCollection(
           Product::whereIn('id',$product->relatedByCategory())
               ->whereNotIn('id',[$product->id])
               ->orderBy('visits','desc')
               ->skip(--$page*$amount)
               ->take($amount)
               ->get()
               ->all()));
    }

    public function ajaxProduct(Product $product){

        $stars = number_format($product->reviews()->avg('stars'),1);
        $attributes=[];
        foreach ($product->items as $item) {

            foreach ($item->attribute as $attr) {
                $attrObj = Attribute::find($attr['attribute_id']);
                $attributes[$attrObj->name][$attr['id']]  = $attr['value'];
                $attributes[$attrObj->name] = array_unique($attributes[$attrObj->name]);
            }
        }
        $productTrans = (new ProductTransformer(new ReviewTransformer(),new showProductTransformer))->transform($product);
        return view('website.components.ajax-product',compact('product','productTrans','attributes','stars'));
    }

    public function favourites(){

        return$this->responseSuccess(
            array_merge(
                ['products'=>
            (new showProductTransformer())->transformCollection(auth()->user()->favourite->all())]
            ,
                ['shops'=>
            (new ShopTransformer())->transformCollection(auth()->user()->favourite_shop->all())]
            )
        );
    }

    public function deleteItems(Product $product)
    {
        foreach ($product->items as $item)
        {
            $item->attribute()->detach();
        }
         $product->items()->delete();
        return back();
    }
    public function setStock(Product $product,Request $request)
    {

        foreach ($product->items as $item)
        {
            $item->amount = $request->stock;
            $item->save();
        }
        return back();
    }

    public function report(){
        return view('admin.products.report',['title'=>'Product Report','products'=>Product::all()]);
    }

    public function reportCalc(Request $request){
        $completed =  Order::whereBetween('created_at',[new Carbon($request->start),new Carbon($request->end)])
            ->where('status','completed')
            ->get();
        $total_in_completed = 0;
        foreach ($completed as $single) {
            foreach ($single->products as $single_product){
                if ($single_product->product_id == $request->product_id){
                    $total_in_completed += $single_product->getOriginal('pivot_quantity');
                }
            }
        }
        $pending =  Order::whereBetween('created_at',[new Carbon($request->start),new Carbon($request->end)])
            ->where('status','pending')
            ->get();
        $total_in_pending = 0;
        foreach ($pending as $single) {
            foreach ($single->products as $single_product){
                if ($single_product->product_id == $request->product_id){
                    $total_in_pending += $single_product->getOriginal('pivot_quantity');
                }
            }
        }
        $total = [
            'completed'=>$total_in_completed,
            'pending'=>$total_in_pending
        ];
        return view('admin.products.report',['title'=>'Product Report','products'=>Product::all(),'total'=>$total]);
    }
}
