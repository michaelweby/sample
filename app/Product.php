<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $dates=['start','end'];

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function items()
    {
        return $this->hasMany(ProductItem2::class);
    }

    public function attributes(){
        return $this->hasManyThrough(Attribute::class,ProductItem2::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function cart(){
        return $this->belongsToMany(Cart::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function ad()
    {
        return $this->hasMany(Ad::class);
    }
    public function favouriteBy(){

        return $this->belongsToMany(User::class,'favourites','product_id');
    }

    public function related(){
        return $this->belongsToMany(Product::class,'related_products','product_id','related_id');
    }

    public function relatedTo(){
        return $this->belongsToMany(Product::class,'related_products','related_id','product_id');
    }
    public function scopeIsActiveShop($query) {
        return $query->whereHas('shop', function($query) {
            $query->where('status', 'active');
        });
    }
    public function scopeInStock($query){
        return $query->whereHas('items',function ($query){

                $query->where('amount' ,'>',0);

        });
    }
    public function scopeNotAd($query){
        return $query->doesntHave('ad');
    }
    public function scopeHasItem($query){
        return $query->has('items');
    }
    public function runningDiscount(){
        if($this->discount
            and $this->start
            and $this->end
            and Carbon::now()->diffInDays($this->start,false) <=0
            and Carbon::now()->diffInDays($this->end,false) >=0)
            return true;
        return false;
    }

    public function newPrice(){
        if($this->discount_type=='pound')
            return  $this->price - $this->discount;

        return  $this->price - $this->discount*$this->price/100;

    }
    public function isSingleItem(){
        return (count($this->items)==1)? true:false;
    }
    public function singleItem(){

            return $this->items()->select('id','price','amount')->first();

    }
    public function isFavourite(){
       return $this->favouriteBy()->where('user_id',auth()->id())->count()? true : false;
    }

    public function have_review(){
        return $this->reviews()->where('user_id',auth()->id())->first();
    }

    public function isElite(){
        return $this->categories()->where('elite',1)->count()?true:false;
    }
    public function relatedByCategory(){
        return array_unique(array_column(DB::table('category_product')
            ->whereIn('category_id',array_column($this->categories->toArray(),'id'))->get()->all(),'product_id'));
    }
    public  function isSingle(){
        return count($this->items);
    }
    public function viewed($ip,$user_id = null){
        $exist = DB::table('product_viewers')
            ->where(['product_id'=>$this->id,'ip'=>$ip])
            ->count();
        if($exist  == 0){
            DB::table('product_viewers')->insert(['product_id'=>$this->id,'ip'=>$ip]);
        }
        return $exist;
    }
    public function hasStarsCount($stars){
        return $this->reviews()->where('stars',$stars)->count();
    }
}
