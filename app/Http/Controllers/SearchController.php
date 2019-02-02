<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Http\Controllers\Transformers\CategoryTransformer;
use App\Http\Controllers\Transformers\ShopTransformer;
use App\Http\Controllers\Transformers\showProductTransformer;
use App\Product;
use App\Shop;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends ApiController
{
    protected $productTransformer;

    /**
     * SearchController constructor.
     * @param $productTransformer
     */
    public function __construct(showProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
    }

    public function search($search){
         $result['products'] = $this->searchProducts($search);
         $result['shops'] = $this->searchShop($search);
         $result['tag'] = $this->searchTag($search);
         return $result;
    }
    public function searchApi(Request $request){
        return $this->search($request->search);
    }
    public function searchView(Request $request){
        $result = $this->search($request->search);
        $products = [];
        foreach ($result['products'] as $product){
            array_push($products,$product);
        }
        foreach ($result['tag'] as $product){
            array_push($products,$product);
        }
//        $products = response()->json($products);
        return view('website.search',['products'=>$products]);
    }
    public function webSearch(Request $request){
        $result = $this->search($request->search);
        $products['products'] = [];
        foreach ($result['products'] as $product){
            array_push($products['products'],$product);
        }
        foreach ($result['tag'] as $product){
            array_push($products['products'],$product);
        }
        $products['shops'] = $result['shops'];
        return $this->responseSuccess($products);
    }

    public function searchProducts($search = null){

        return $this->productTransformer->transformCollection(
            Product::where('name','like',"%$search%")->get()->all()
        );
    }

    public function searchCategory($search = null){
        $products = [];

        foreach (Category::where('name','like',"%$search%")->where('parent_id',0)->get() as $category){

             $products[$category->name] = $this->productTransformer->transformCollection(Product::whereIn('id',
                                             DB::table('category_product')->where('category_id',$category->id)->pluck('product_id')
                                         )->get()->all());
             foreach ($category->children as $child){
                  $products[$category->name][$child->name] =
                      $this->productTransformer->transformCollection(
                      Product::whereIn('id',
                          DB::table('category_product')->where('category_id',$child->id)->pluck('product_id')
                      )->get()->all());
             }

         }
        return $products;
    }

    public function searchShop($search = null){
        $shops = (new ShopTransformer())->transformCollection(Shop::where('title','like',"%$search%")->get()->all());

//        foreach (Shop::where('title','like',"%$search%")->get() as $shop){
//
//            $products[$shop->title]  = $this->productTransformer->transformCollection(
//                Product::where('shop_id',$shop->id)->get()->all()
//            );
//
//        }
        return $shops;

    }

    public function searchTag($search = null){
        $products = [];

        foreach (Tag::where('name','like',"%$search%")->get() as $tag){

            $products = $this->productTransformer->transformCollection(
                $tag->products->all()
            );

        }
        return $products;
    }

    public function filterScreen(){


        return $this->responseSuccess([
            'min_price'=>Product::min('price'),
            'max_price'=>Product::max('price'),
            'categories'=>(new Category)->tree(),
//            'attributes'=>(new Category)->treeWithAttributes($attributes),
        ]);
    }
    public function categoryAttributes($category){
        $attributes = Attribute::whereIn('name',['color','size','Material'])->pluck('id');
       return (new Category)->withAttributes($category,$attributes);
    }
    public function filter(Request $request){

        $products = $request->category_id?
           Category::find($request->category_id)
               ->products()->where('name','like','%'.$request->seach_key.'%')->where('price','>=',$request->min_price)->where('price','<=',$request->max_price)->get()
           : Product::where('name','like','%'.$request->seach_key.'%')->where('price','>=',$request->min_price)->where('price','<=',$request->max_price)->get();
        $filtered =[];


        if (isset($request->attr) and count($request->attr)>0){
            foreach ($products as $product){
                if (count($product->items) >0){
                    foreach ($product->items as $item){
                        foreach ($item->attribute as $attribute){
                            if (in_array($attribute->attribute_id,$request->attr)){
                                $filtered []= $product;
                            }
                        }

                    }
                }

            }
            return (new showProductTransformer())->transformCollection($filtered);
        }
        else{
            return (new showProductTransformer())->transformCollection($products->all());
        }

    }

}
