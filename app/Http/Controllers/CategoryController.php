<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Attribute;
use App\Category;
use App\Http\Controllers\Transformers\CategoryTransformer;
use App\Http\Controllers\Transformers\showProductTransformer;
use App\Http\Requests\CategoryRequest;
use App\Product;
use App\ProductViewr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $title = 'Category';

    protected $categoryTransformer;

    /**
     * CategoryController constructor.
     * @param $categoryTransformer
     */
    public function __construct(CategoryTransformer $categoryTransformer)
    {
        $this->categoryTransformer = $categoryTransformer;
    }


    public function index()
    {
        $categories=Category::paginate(15);
        return view('admin.categories.index')->with(['title'=>$this->title,'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create')->with(['title'=>$this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $category=new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->parent_id=$request->parent_id;
        $category->url=$request->url;
        if($request->hasFile('image'))
            $category->image=app('help')->help($request->image);
        if($request->hasFile('cover'))
            $category->cover=app('help')->help($request->cover);
        else
            $category->image='uploads/default.png';
        $category->save();
        return redirect(PATH.'/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.categories.show',['category'=>$category,'title'=>$this->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with(['title'=>$this->title,'data'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {

        $category->name=$request->name;
        $category->description=$request->description;
        $category->parent_id=$request->parent_id;
        $category->url=$request->url;
        if($request->hasFile('image')) {
            if(file_exists($category->image))
            {
                unlink($category->image);
            }
            $category->image = app('help')->help($request->image);
        }
        if($request->hasFile('cover')) {
            if(file_exists($category->cover))
            {
                unlink($category->cover);
            }
            $category->cover = app('help')->help($request->cover);
        }
        $category->save();
        return redirect(PATH.'/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->image !='uploads/default.png' and file_exists($category->image))
        {
                unlink($category->image);
        }
        $category->freeChildren($category);
        $category->delete();
        return redirect(PATH.'/category');
    }
    public function indexApi(){
        return $this->responseSuccess($this->categoryTransformer->transformCollection(Category::where('parent_id',0)->get()->all()));
    }

    public function singleApi($category){
        $category = Category::find($category);
        if(!$category){
            return $this->responseNotFound('No Category with that ID');
        }
        $productTransformer = new showProductTransformer();

        $ads = $productTransformer->transformCollection(
            Product::whereIn('id',
                $row_ads =(new Ad)->active()->inCategory($category->id)->take(5)->inRandomOrder()->pluck('product_id')->toArray())->get()->all());
        foreach($row_ads as $ad){
            Ad::where('product_id',$ad)->increment('shows');
        }
        $products =DB::table('categories')
            ->where('categories.id',$category->id)
            ->join('category_product','category_product.category_id','categories.id')
            ->pluck('product_id');
        return $this->responseSuccess([
            'category'=>$this->categoryTransformer->transform($category),
            'ads'=>$ads,
            'products'=>$productTransformer->transformCollection(
                Product::whereIn('id',$products)
                    ->orderBy('visits','desc')
                    ->take(10)
                    ->get()
                    ->all()
            ),
            ]);
    }

    public function siteCategory(Category $category){
        $attributes = Attribute::whereIn('name',['color','size'])->pluck('id');
        $category_attributes = $category->withAttributes($category->id,$attributes);
        return view('website.category',compact('category','category_attributes'));
    }

    public function singleCategoryPaginate($category,$page=1,$amount = 10){
        $category = Category::find($category);
        if(!$category){
            return $this->responseNotFound('No Category with that ID');
        }
        $products = DB::table('categories')
            ->where('categories.id',$category->id)
            ->join('category_product','category_product.category_id','categories.id')
            ->pluck('product_id');
        $transformer = new showProductTransformer();
            return $this->responseSuccess($transformer->transformCollection(
                Product::whereIn('id',$products)
                    ->orderBy('visits','desc')
                    ->skip(--$page*$amount)
                    ->take($amount)
                    ->get()
                    ->all()
        ));
    }

}
