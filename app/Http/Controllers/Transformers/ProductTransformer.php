<?php
/**
 * Created Michael.
 * Date: 6/14/2018
 * Time: 9:13 PM
 */

namespace App\Http\Controllers\Transformers;

use App\Ad;
use App\Attribute;
use App\Product;
use Illuminate\Support\Facades\DB;

class ProductTransformer extends Transformer
{
    protected $reviewTransformer;
    protected $showProductTransformer;

    /**
     * ProductTransformer constructor.
     * @param $reviewTransformer
     * @param $showProductTransformer
     */
    public function __construct(ReviewTransformer $reviewTransformer,
                                showProductTransformer $showProductTransformer)
    {
        $this->reviewTransformer = $reviewTransformer;
        $this->showProductTransformer = $showProductTransformer;
    }

    /**
     * ProductTransformer constructor.
     * @param $reviewTransformer
     */


    public function transform($product)
    {
        $singleItem = [];
        $discount = [];
        $discount['valuePercentage'] = 0;
        $discount['new_price'] = 0;
        $reviews = $this->reviewTransformer->transformCollection($product->reviews->all());
        $attributes = [];
        $attributesFinal = [];
        $items = [];
        $ads =  $this->
                showProductTransformer->
                transformCollection(
                    Product::find(
                        $row_ads = (new Ad)->active()->inProduct()->take(5)->inRandomOrder()->pluck('product_id')->toArray())->all());

        foreach($row_ads as $ad){
            Ad::where('product_id',$ad)->increment('shows');
        }
        $related = $this->showProductTransformer->transformCollection(Product::whereIn('id',$product->relatedByCategory())->orderBy('visits','desc')->take(10)->get()->all());

        if($product->runningDiscount()){
            $discount['valuePercentage'] =
                $product['discount_type'] == 'percentage'?
                    $product['discount']:
                    ($product['discount'])/$product['price']*100;
            $discount['new_price'] = $product->newPrice();
        }
        if (!$product->isSingleItem()) {
            foreach ($product->items as $item) {

                foreach ($item->attribute as $attr) {
                    $attrObj = Attribute::find($attr['attribute_id']);
                    $attributes[$attrObj->name][$attr['id']]  = $attr['value'];
                    $attributes[$attrObj->name] = array_unique($attributes[$attrObj->name]);
                }
            }
            $i = 0;
            foreach ($attributes as $key => $attribute) {
                $attributesFinal[$i]['name'] = $key;
                $values = [];
                foreach($attribute as $id=>$val){
                    array_push($values,['id'=>$id,'value'=>$val]);
                }
                $attributesFinal[$i]['values'] = (array) $values;
                $i++;
            }
        }


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

        return [
            'id'=>$product['id'],
            'name'=>$product['name'],
            'description'=>str_replace("\n",' ',str_replace(["\r","\""],'',strip_tags($product['description']))),
            'image'=>$product['image'],
            'images'=>array_column($product->images->all(),'image'),
            'categories'=>(new CategoryTransformer())->transformCollection($product->categories->all()),
            'shop_id'=>$product->shop->id,
            'shop'=>$product->shop->title,
            'shop_logo'=>$product->shop->logo,
            'price'=>$product['price'],
            'discount'=>$discount,
            'isElite'=>$product->isElite(),
            'isFavourite'=>$product->isFavourite(),
            'reviews'=>$reviews,
            'isSingleItem'=>$product->isSingleItem(),
            'items'=>$items,
            'attributes'=>$attributesFinal,
            'ads'=>$ads,
            'related'=>$related,
        ];
    }
}