<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $guarded = ['user_id'];
    protected $fillable = ['first_name','last_name','address','phone','email','user_id','floor','apartment','land_mark'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
