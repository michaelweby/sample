<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/17/2018
 * Time: 3:27 AM
 */

namespace App\Http\Controllers\Transformers;


use App\Coupon;
use App\Http\Controllers\CartController;
use App\Shipping;

class ConfirmationTransformer extends Transformer
{
    protected $shipping;

    protected $coupon;

    protected $discount;

    /**
     * ConfirmationTransformer constructor.
     * @param $shipping
     * @param $coupon
     * @param $discount
     */
    public function __construct(Shipping $shipping,Coupon $coupon = null, $discount)
    {
        $this->shipping = $shipping;
        $this->coupon = $coupon;
        $this->discount = $discount;
    }


    public function transform($item=null)
    {
        return[
            'shipping'=>[
                'name'=>$this->shipping->first_name.' '.$this->shipping->last_name,
                'address'=>$this->shipping->address,
                'phone'=>$this->shipping->phone,
                'email'=>$this->shipping->email,
                'floor'=>$this->shipping->floor,
                'apartment'=>$this->shipping->apartment,
                'land_mark'=>$this->shipping->land_mark,
            ],
            'products'=>(new CartController())->showItems()->original,
            'coupon'=>$this->coupon?$this->coupon->code:'',
            'discount'=>$this->discount,

        ];
    }
}