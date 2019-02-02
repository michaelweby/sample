<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Banner;
use App\Cart;
use App\Category;
use App\FeaturedProduct;
use App\Mail\ResetPasswordMail;
use App\Product;
use App\User;
use App\Http\Controllers\Transformers\CategoryTransformer;
use App\Http\Controllers\Transformers\showProductTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class HomeController extends ApiController
{
    // return  main api main screen
    public function main(){
        $categoryTransformer = new CategoryTransformer ;
        $showProductTransformer = new showProductTransformer ;
        $products = Product::where('priorty','>',0)->isActiveShop()->inStock()->orderBy('priorty','asc')->take(15)->get()->all();
        $ads = $showProductTransformer->transformCollection(
            Product::find($row_ads=(new Ad)->home()->active()->inRandomOrder()->limit(5)->pluck('product_id')->toArray())->all());
        foreach($row_ads as $ad){
            Ad::where('product_id',$ad)->increment('shows');
        }
        return $this->responseSuccess(
            [
                'categories'=>
                    $main_categories = $categoryTransformer->transformCollection(Category::where('parent_id',0)->get()->all()),
                'ads'
                =>$ads,
                'products'=>$showProductTransformer->transformCollection($products),
                'cart_count'=>Cart::countItems(),
            ]);
    }

    public function siteHome(){
        $featured = FeaturedProduct::limit(10)->get();
        $banners = Banner::orderBy('order','desc')->get();
        return view('website.home',['featured'=>$featured,'banners'=>$banners]);
    }
    public function homeData(){
        $mainScreen = $this->main();
        $mainScreen = json_decode($mainScreen->content());
        $mainScreen =   $mainScreen->data;
        return response()->json($mainScreen);
    }


    public function signView(){
        return view('website.sign');
    }

    public function about(){
        return view('website.about');
    }
    public function contact(){
        return view('website.contact');
    }
    public function check_mail(Request $request){
         $request = json_decode($request->getContent());
        if (User::where('email',$request->email)->first()){
            $this->resetPasswordMail($request->email);
            return $this->responseSuccess('true');
        }
        return $this->responseSuccess('false');
    }

    public function webCheckMail(Request $request){
        if (User::where('email',$request->email)->first()){
            $this->resetPasswordMail($request->email);
            return redirect('/');
        }
        return back()->withErrors(['no_mail']);
    }

    public function resetPasswordMail($email){
        $token = hash_hmac('sha256', str_random(40), config('app.key'));
        if($record = DB::table('password_resets')->where('email',$email)->first()){
            DB::table('password_resets')->where('email',$email)->update(['token'=>$token,'created_at'=>Carbon::now()]);
        }else{
            DB::table('password_resets')->insert(['email'=>$email,'token'=>$token,'created_at'=>Carbon::now()]);
        }
        \Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function checkResetToken($token){
        if ($record = DB::table('password_resets')->where('token',$token)->first()){
            if(Carbon::now()->diffInMinutes($record->created_at,false) > -1440){
                return view('website.reset_password',['email'=>$record->email,'token'=>$record->token]);
            }else{
                $token = hash_hmac('sha256', str_random(40), config('app.key'));
                DB::table('password_resets')->where('email',$record->email)->update(['token'=>$token,'created_at'=>Carbon::now()]);
                \Mail::to($record->email)->send(new ResetPasswordMail($token));
                return redirect('/');
            }
        }
    }

    public function resetPassword(Request $request){
        if (DB::table('password_resets')->where('email',$request->email)->where('token',$request->token)->first()){
            if ($request->password == $request->password_confirm){
                $user = User::where('email',$request->email)->first();
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect('sign');
            }
        }else{
            return redirect('/')->withErrors('wrong data');
        }
    }

    public function forgetPasswordView(){
        return view('website.forget_password');
    }
}
