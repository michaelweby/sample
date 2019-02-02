<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    public $title = 'Ads' ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::paginate(15);
        return view('admin.ads.index',['title'=>$this->title,'ads'=>$ads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ads.create',['title'=>$this->title,'products'=>Product::whereDoesntHave('ad')->get(),'categories'=>Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'product_id'=>'required',
            'from'=>'required',
            'to'=>'required',
        ]);
        $ad = new Ad();
        $ad->product_id = $request->product_id;
        $ad->from = new Carbon($request->from);
        $ad->to= new Carbon($request->to);
        if ($request->has('active')){
            $ad->active = 1;
        }
        else{
            $ad->active = 0;
        }
        if ($request->has('home')){
            $ad->home = 1;
        }
        if ($request->has('single_product')){
            $ad->single_product = 1;
        }
        $ad->save();
        $ad->categories()->attach($request->categories);
        return redirect(PATH.'/ads');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        return view('admin.ads.show',['ad'=>$ad,'title'=>$this->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        $categories_ids = $ad->categories()->pluck('id');
        return view('admin.ads.edit',['title'=>$this->title,'products'=>Product::all(),'ad'=>$ad,'categories'=>Category::all(),'categories_ids'=> $categories_ids]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $valid = $request->validate([
            'product_id'=>'required',
            'from'=>'required',
            'to'=>'required',
        ]);
        $ad->product_id = $request->product_id;

        $ad->from = new Carbon($request->from);
        $ad->to= new Carbon($request->to);
        if ($request->has('active')){
            $ad->active = 1;
        }
        else{
            $ad->active = 0;
        }
        if ($request->has('home')){
            $ad->home = 1;
        }else{
            $ad->home = 0;
        }
        if ($request->has('single_product')){
            $ad->single_product = 1;
        }else{
            $ad->single_product = 0;
        }
        $ad->save();
        $ad->categories()->sync($request->categories);
        return redirect(PATH.'/ads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect(PATH.'/ads');
    }
}
