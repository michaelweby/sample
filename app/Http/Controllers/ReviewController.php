<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Transformers\ReviewTransformer;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends ApiController
{
    protected $reviewTransformer;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'Reviews';

    /**
     * ReviewController constructor.
     * @param $reviewTransformer
     */
    public function __construct(ReviewTransformer $reviewTransformer)
    {
        $this->reviewTransformer = $reviewTransformer;
    }

    public function index(Product $product)
    {
        return view('admin.reviews.index',['title'=>$this->title,'reviews'=>$product->reviews]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function hide( Review $review)
    {
        $review->hidden = 1;
        $review->save();
        return response()->json(true);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show( Review $review)
    {
        $review->hidden = 0;
        $review->save();
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        $review->delete();
        return back();
    }
    public function checkIfExist(Product $product){

        if($review = $product->reviews()->where('user_id',auth()->id())->first()){

            return $this->reviewTransformer->transform($review);
        }
        // return 0 if not exist
        return 0;
    }
    public function add(Request $request,Product $product){

        $request = json_decode($request->getContent(),false);

        if(is_array($this->checkIfExist($product))){
            $obj =  $product->reviews()->where('user_id',auth()->id())->first();
            $obj->stars =$request->stars;
            $obj->review=$request->review;
            $obj->save();
            return $this->responseSuccess('Review Updated');
        }
        $product->reviews()->create([
            'stars'=>$request->stars,
            'review'=>$request->review,
            'user_id'=>auth()->id()
        ]);
        return $this->responseSuccess('Review Created');
    }

    public function storeFromWeb(Request $request,Product $product){

        if ($request->review_id){
            $product->reviews()->update([
                'stars'=>$request->stars,
                'review'=>$request->review,
                'user_id'=>auth()->id()
            ]);
            return back();
        }
        $product->reviews()->create([
            'stars'=>$request->stars,
            'review'=>$request->review,
            'user_id'=>auth()->id()
        ]);
        return back();
    }
}
