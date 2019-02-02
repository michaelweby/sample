<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
        protected $fillable = [
        'stars', 'review','user_id'
        ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
