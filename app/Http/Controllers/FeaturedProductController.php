<?php

namespace App\Http\Controllers;

use App\FeaturedProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturedProductController extends Controller
{
    protected $title =  'Featured Products';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featured = FeaturedProduct::all();

        return view('admin.featured.index',['featured'=>$featured,'title'=>$this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products= Product::select(['id','name'])->get();
        return view('admin.featured.create',['products'=>$products,'title'=>$this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image=app('help')->help($request->image);
        FeaturedProduct::create([
            'product_id'=>$request->product_id,
            'x_translate'=>$request->x_translate,
            'y_translate'=>$request->y_translate,
            'image'=>$image,
        ]);
        return redirect(PATH.'/featuredProduct');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FeaturedProduct  $featuredProduct
     * @return \Illuminate\Http\Response
     */
    public function show(FeaturedProduct $featuredProduct)
    {
        dd($featuredProduct);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FeaturedProduct  $featuredProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(FeaturedProduct $featuredProduct)
    {
        $products= Product::select(['id','name'])->get();
        return view('admin.featured.edit',['products'=>$products,'featured'=>$featuredProduct,'title'=>$this->title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FeaturedProduct  $featuredProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeaturedProduct $featuredProduct)
    {
        if ($request->has('image')){
            $image=app('help')->help($request->image);
            $featuredProduct->image = $image;
        }
        $featuredProduct->x_translate = $request->x_translate;
        $featuredProduct->y_translate = $request->y_translate;
        $featuredProduct->product_id = $request->product_id;
        $featuredProduct->save();
        return redirect(PATH.'/featuredProduct');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FeaturedProduct  $featuredProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeaturedProduct $featuredProduct)
    {
        //
    }
}
