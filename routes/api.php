<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|                               API Routes                                |
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','LoginController@login');
Route::post('socialLogin','LoginController@socialLogin');
Route::post('register','RegisterController@create');
Route::post('socialRegister','RegisterController@socialCreate');
Route::group(['middleware'=>'auth:api'],function (){
    Route::get('favourite/{id}','ProductController@favourite');
    Route::get('favourite_shop/{id}','ShopController@favourite');
    Route::get('logout','LoginController@logout');
    Route::get('errors','RegisterController@notValid');
    Route::get('add_review/{product}','ReviewController@checkIfExist');
    Route::post('store_review/{product}','ReviewController@add');
    Route::get('count_cart/','CartController@countCart');
    Route::get('add_cart/{product}/{quantity?}','CartController@add');
    Route::get('edit_cart/{product}/{quantity}','CartController@editItem');
    Route::post('delete_cart_item','CartController@deleteItem');
    Route::post('cart','CartController@showItems');
    Route::get('total_cart/',function (){
        return (new \App\Cart())->total();
    });
    Route::get('checkout/','CartController@checkout');
    Route::get('cart_items/',function (){
        return (new \App\Cart)->cartItems();
    });
    Route::get('userShipping','ShippingController@indexApi');
    Route::post('add_shipping','ShippingController@addApi');
    Route::post('apply_coupon','CouponController@applyApi');
    Route::post('confirmation','OrderController@confirm');
    Route::post('order','OrderController@order');
    Route::get('personal_info','UserController@personalInfo');
    Route::post('edit_personal_info','UserController@editPersonalInfo');
    Route::get('favourites','ProductController@favourites');
    Route::get('my_orders','OrderController@userOrders');
    Route::get('follow_orders','OrderController@followOrders');
    Route::get('order_details/{order}','OrderController@orderDetails');
    Route::post('update_image','UserController@update_image');

});
Route::group(['middleware'=>'ApiToken'],function () {
    Route::get('mainScreen', 'HomeController@main');
    Route::post('products/{page?}/{amount?}','ProductController@paginate');
    Route::get('productPaginate/{product}/{page?}/{amount?}','ProductController@singleProductPaginate');
    Route::get('category/{category}','CategoryController@singleApi');
    Route::get('categoryPaginate/{category}/{page?}/{amount?}','CategoryController@singleCategoryPaginate');
    Route::get('shop/{shop}','ShopController@singleApi');
    Route::get('shopPaginate/{shop}/{page?}/{amount?}','ShopController@singleShopPaginate');
    Route::get('categories','CategoryController@indexApi');
    Route::get('product/{product}','ProductController@showApi');
    Route::get('search/{search}','SearchController@searchApi');
    Route::get('search_category/{search}','SearchController@searchCategory');
    Route::get('search_shop/{search}','SearchController@searchShop');
    Route::get('search_tag/{search}','SearchController@searchTag');
    Route::get('filter_screen','SearchController@filterScreen');
    Route::get('category_attributes/{category}','SearchController@categoryAttributes');
    Route::get('filter','SearchController@filter');
});
Route::post('check_mail_exist','HomeController@check_mail');
Route::post('image','HomeController@image');
Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');





//Route::middleware('auth_dump:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
