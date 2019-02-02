<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Transformers\ShippingTransformer;
use App\Http\Requests\ShippingRequest;
use App\Order;
use App\Shipping;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends ApiController
{
    public function add(ShippingRequest $request)
    {
        Shipping::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'floor' => $request->floor,
            'land_mark' => $request->land_mark,
            'apartment' => $request->apartment,
            'user_id' => auth()->id(),
        ]);
        return redirect(PATH . '/');
    }

    public function addApi(Request $request)
    {
        $request = json_decode($request->getContent());
        $shipping = Shipping::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'floor' => $request->floor,
            'land_mark' => $request->land_mark,
            'apartment' => $request->apartment,
            'user_id' => auth()->id(),
        ]);
        return $this->responseSuccess([
            'id' => $shipping->id,
        ]);
    }

    public function addAjax(Request $request)
    {
        $request = $request->all()['request'];

        $shipping = Shipping::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'email' => $request['email'],
            'floor' => $request['floor'],
            'land_mark' => $request['landmark'],
            'apartment' => $request['apartment'],
            'user_id' => auth()->id(),
        ]);
        return $this->responseSuccess([
            'id' => $shipping->id,
        ]);
    }

    public function showApi(Shipping $shipping)
    {
        return $shipping;
    }

    public function edit(ShippingRequest $request, Shipping $shipping)
    {
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->last_name = $request->phone;
        $shipping->address = $request->address;
        $shipping->email = $request->email;
        $shipping->floor = $request->floor;
        $shipping->land_mark = $request->land_mark;
        $shipping->apartment = $request->apartment;
        $shipping->save();
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
    }

    public function getAll(User $user)
    {
        return view('admin.ajax.radio_options', ['shippings' => $user->shipping, 'user' => $user]);
    }

    public function indexApi()
    {
        $shippingTransformer = new ShippingTransformer();
        return $this->responseSuccess([
            'shipping' => $shippingTransformer->transformCollection(auth()->user()->shipping->all()),
        ]);
    }
    public function ajaxDelete($shipping){

        $shipping = Shipping::find($shipping);
        $shipping->user_id = null;
        $shipping->save();
    }
}
