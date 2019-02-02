<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable,CanResetPassword;
    protected $dates = ['birthday'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'email', 'password','first_name','last_name','phone','address','username','type','activated','facebook_id','google_id','image','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // shop relation (one to one)
    public function shop(){
        return $this->hasOne(Shop::class,'owner_id');
    }

    // customer cart relation(one to one)
    public function cart(){
        return $this->hasOne(Cart::class,'customer_id');
    }

    //shipping relation
    public function shipping(){
        return $this->hasMany(Shipping::class);
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function favourite(){
        return $this->belongsToMany(Product::class,'favourites','user_id');
    }

    public function order(){
        return $this->hasMany(Order::class,'customer_id');
    }

    public function favourite_shop(){
        return $this->belongsToMany(Shop::class,'shop_favorites','user_id');
    }
    /**
     * @param $column
     * @param $value
     * @return int
     */
    public static function isUnique($column , $value){

        if(User::where($column, $value)->count()){return 0;}
        return 1 ;
    }

    public function vendors(){

        return User::where('type','vendor')->get();
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public static function favourites(){
        if (auth()->user()){
            return auth()->user()->favourite->count();
        }
        return 0;
    }

    public function name()
    {
        return $this->first_name.' '.$this->last_name;
    }

}
