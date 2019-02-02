<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    protected  $dates = ['from','to'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function isActive(){
        if ($this->active and Carbon::now()->diffInMinutes($this->from,false)<0 and Carbon::now()->diffInMinutes($this->to,false)>0){
            return true;
        }
        return false;
    }
    public function scopeHome($query){
        return $query->where('home',1);

    }
    public function scopeInProduct($query){
        return $query->where('single_product',1);

    }
    public function scopeActive($query){
        return $query->where('active',1)->where('from','<',Carbon::now())->where('to','>',Carbon::now());

    }
    public function scopeInCategory($query,$category){
        return $query->whereHas('categories',function ($query) use ($category){
            $query->where('category_id',$category);
        });

    }

}
