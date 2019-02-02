<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function hasAds(){
        return $this->belongsToMany(Ad::class);
    }
    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function children(){
        return $this->hasMany(Category::class,'parent_id');
    }
    public function childrenRecursive(){
        return $this->children()->with('childrenRecursive');
    }
    public function freeChildren($category){
        foreach (Category::where('parent_id',$category->id)->get() as $child){
            $child->parent_id = 0;
            $child->save();
        }
    }

    public function tree(){
        return $tree = $this->where('parent_id',0)->with('childrenRecursive')->get();
    }
    public function treeWithAttributes($attributes){
        $values = [];
        $i =0;
        foreach (Category::all() as $category) {
            $items = [];
            $attr = [];
            foreach ($category->products as $product) {
                $items [] = @$product->items;
            }


                foreach ($items as $items_product) {
                    foreach ($items_product as $item){
                        $attr[] = $item->attribute;
                    }
                }

            foreach ($attr as $single) {
                foreach ($single as $item_attr) {
                    if (in_array($item_attr->attribute_id, $attributes->all())) {
                        $main_attr = Attribute::find($item_attr->attribute_id)->name;
                        $values[$category->id][$main_attr][$item_attr->id] = $item_attr->value;
                        $values[$category->id][$main_attr] =  array_unique($values[$category->id][$main_attr]);
                    }
                }

            }

        }
        $final = [];
        foreach ($values as $key=>$value){

            foreach ($value as $attr_name=>$attr){

                foreach ($attr as $id=>$val){
                    $attrs[]=['id'=>$id,'key'=>$attr_name,'value'=>$val];
                }

            }
            $final []=['category_id'=>$key,'values'=>$attrs];
        }
        return $final;
    }
    public function withAttributes($category,$attributes){
        return DB::table('categories')
            ->join('category_product','categories.id','=','category_product.category_id')
            ->join('products','category_product.product_id','=','products.id')
            ->join('product_items','products.id','product_items.product_id')
            ->join('product_groups','product_items.id','product_groups.item_id')
            ->join('attribute_values','product_groups.attribute_id','attribute_values.attribute_id')
            ->join('attributes','attributes.id','attribute_values.attribute_id')
            ->whereIn('attributes.id',$attributes->all())
            ->where('categories.id',$category)
            ->select('attribute_values.value','attribute_values.id','attributes.name')
            ->get();
    }
    public function print_tree($category){
        if(count($category->children_recursive)>0){
            foreach ($category->children_recursive as $child)
                return $this->print_tree($child);
        }
        return null;
    }
    public function treeDepth($categories){
        $depth = 0;
        foreach ($categories as $category){
            $d = $this->treeDepth($category);
            if ($d > $depth) {
                $depth = $d;
            }
        }
        return 1 + $depth;
    }
}
