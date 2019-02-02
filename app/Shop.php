<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{
    protected $fillable = [
        'title', 'logo', 'address','phone','description','bank_account_number','bank_account_name','commission'
    ];
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function favouriteBy(){
        return $this->belongsToMany(User::class,'shop_favorites','shop_id');
    }
    public function isActive(){
        if ($this->status == 'active'){
            return true;
        }
        return false;
    }
    public function isFavourite(){
        return $this->favouriteBy()->where('user_id',auth()->id())->count()? true : false;
    }
    public function orders(){
        return DB::table('shops')
            ->join('products','products.shop_id','shops.id')
            ->join('product_items','product_items.product_id','products.id')
            ->join('order_product','product_items.product_id','order_product.product_id')
            ->join('orders','order_product.order_id','orders.id')
            ->groupBy('orders.id')
            ->where('shops.id',$this->id)
            ->get()
            ;
    }

}
