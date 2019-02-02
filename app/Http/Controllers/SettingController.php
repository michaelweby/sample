<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function update(Request $request){

        if ($setting = Setting::first()){
            $setting->shipping_cost = $request->shipping_cost;
            $setting->facebook = $request->facebook;
            $setting->instagram = $request->instagram;
            $setting->youtube = $request->youtube;
            $setting->google_play = $request->google_play;
            $setting->apple_store = $request->apple_store;
            $setting->address = $request->address;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->p1_title = $request->p1_title;
            $setting->p1 = $request->p1;
            $setting->p2_title = $request->p2_title;
            $setting->p2 = $request->p2;
            $setting->p3_title = $request->p3_title;
            $setting->p3 = $request->p3;
            $setting->p4_title = $request->p4_title;
            $setting->p4 = $request->p4;
            $setting->save();
            return back();
        }
        $setting = new Setting();
        $setting->shipping_cost = $request->shipping_cost;
        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->youtube = $request->youtube;
        $setting->google_play = $request->google_play;
        $setting->apple_store = $request->apple_store;
        $setting->address = $request->address;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->p1_title = $request->p1_title;
        $setting->p1 = $request->p1;
        $setting->p1_title = $request->p2_title;
        $setting->p1 = $request->p2;
        $setting->p1_title = $request->p3_title;
        $setting->p1 = $request->p3;
        $setting->p1_title = $request->p4_title;
        $setting->p1 = $request->p4;
        $setting->save();
        return back();

    }
}
