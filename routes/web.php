<?php
define('PATH','dashboard');
//Auth::loginUsingId (1);
Route::group(['prefix'=>PATH],function (){
    Route::group(['middleware'=>'guest'],function () {
        Route::view('login', 'admin.users.login');
    });

    Route::post('checkLogin','UserController@checkLogin');

    //  admin middleware
    Route::group(['middleware'=>'admin'],function (){
        Route::get('/','DashboardController@main');
        Route::resources([
            'users'=>'UserController',
            'shops'=>'ShopController',
            'coupons'=>'CouponController',
            'orders'=>'OrderController',
            'tags'=>'TagController',
            'ads'=>'AdController',
            'featuredProduct'=>'FeaturedProductController',
            'banner'=>'BannerController',
            'products.reviews'=>'ReviewController',
        ]);
        Route::get('getUsers/{type}','UserController@index');
        Route::get('logout','UserController@logout');
        Route::post('getProductItems/{product}','ProductController@getItems');
        Route::post('getProductItem/{product_item}','ProductController@getItem');
        Route::post('applyCoupon','CouponController@apply');
        Route::post('userShipping/{user}','ShippingController@getAll');
        Route::post('review/hide/{review}','ReviewController@hide');
        Route::post('review/show/{review}','ReviewController@show');
        Route::post('product/{product}/unrelated/{related}','ProductController@unrelated');
        Route::post('product/related/{product}','ProductController@related');
        Route::get('subscribers','SubscriberController@index');
        Route::get('delete_subscribers/{subscriber}','SubscriberController@destroy');
        // excel upload
        Route::get('import-export-csv-excel',array('as'=>'excel.import','uses'=>'ExcelController@importExportExcelORCSV'));
        Route::post('import-csv-excel',array('as'=>'import-csv-excel','uses'=>'ExcelController@switchUploader'));
        Route::get('download-excel-file/{type}', array('as'=>'excel-file','uses'=>'FileController@downloadExcelFile'));
        Route::view('setting', 'admin.settings',['title'=>'Setting','settings'=>\App\Setting::first()]);
        Route::post('saveSetting', 'SettingController@update');
        Route::post('searchTable', 'AjaxController@searchTable');
        Route::post('search_shops', 'AdminSearchController@shops');
        Route::post('search_coupons', 'AdminSearchController@coupons');
        Route::post('search_products', 'AdminSearchController@products');
        Route::post('search_users/{type}', 'AdminSearchController@users');
        Route::post('tag_products/{tag}', 'TagController@tagProducts');
        Route::get('finance/', 'FinanceController@report');
        Route::post('finance_report/', 'FinanceController@analyze');
        Route::delete('delete_items/{product}', 'ProductController@deleteItems');
        Route::post('set_stock/{product}', 'ProductController@setStock');
        Route::get('product-report', 'ProductController@report');
        Route::post('product_report', 'ProductController@reportCalc');
    });

//    Route::group(['middleware'=>'customer',function(){}]);


});
Route::get('user/activation/{token}', 'UserController@activateUser')->name('user.activate');

Route::get('checkUnique','UserController@checkUsername');

//Route::get('add_product/{product}/{quantity?}','CartController@add');
Route::get('cart_items/','CartController@cartItems');
Route::post('update_cart/','CartController@update');

Route::get('delete_cart_item/{cart}','CartController@delete');
Route::get('pass',function (){
    return bcrypt('123456');
});

@include ('web1.php');
//testing inner functions
Route::get('count_cart/','CartController@countCart');
Route::get('total_cart/',function (){
    return (new \App\Cart())->total();
});
Route::get('checkout/','CheckoutController@checkout');
Route::get('category_tree/',function (){
    return (new \App\Category())->tree();
});
Route::view('tree','admin.categories.tree_checkboxs');

// website routes
Route::get('/','HomeController@siteHome')->name('home');
Route::get('about-us','HomeController@about')->name('about');
Route::get('contact-us','HomeController@contact')->name('contact');
Route::get('homeData','HomeController@homeData');
Route::post('homePaginate/{page?}/{amount?}','ProductController@homePaginate');
Route::get('category/{category}','CategoryController@siteCategory');
Route::get('shop/{shop}','ShopController@siteShop');
Route::get('product/{product}','ProductController@siteProduct');
Route::get('productItems/{product}','ProductController@productItems');

Route::post('signUp','RegisterController@signUp');
Route::post('signIn','LoginController@signIn');
Route::get('ajax-product/{product}','ProductController@ajaxProduct');
Route::get('search  ','SearchController@searchView');
Route::get('web_search  ','SearchController@webSearch');
Route::get('product_related/{product}','ProductController@showApi');
Route::get('productPaginate/{product}/{page?}/{amount?}','ProductController@singleProductPaginate');
Route::get('category_products/{category}','CategoryController@singleApi');
Route::get('categoryPaginate/{category}/{page?}/{amount?}','CategoryController@singleCategoryPaginate');
Route::get('shop_product/{shop}','ShopController@singleApisingleApi');
Route::get('shopPaginate/{shop}/{page?}/{amount?}','ShopController@singleShopPaginate');
Route::get('add_subscriber/{email}','SubscriberController@add');
Route::get('confirm_subscribe/{token}','SubscriberController@confirm');
Route::get('forget-password','HomeController@forgetPasswordView');
Route::post('check-mail-exist','HomeController@webCheckMail');
Route::get('confirm_reset_password/{token}','HomeController@checkResetToken');
Route::post('reset-password','HomeController@resetPassword');
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
Route::get('/redirect/google', 'SocialAuthGoogleController@redirect');
Route::get('/callback/google', 'SocialAuthGoogleController@callback');
Route::group(['middleware'=>'customer'],function (){
    Route::get('favourite/{id}','ProductController@favourite');
    Route::get('favourite-shop/{id}','ShopController@favourite');
    Route::get('cart','CartController@webCart');
    Route::get('edit_cart/{product}/{quantity}','CartController@editItem');
    Route::post('delete_cart_items','CartController@ajaxDeleteItem');
    Route::get('add_cart/{product}/{quantity?}','CartController@add');
    Route::get('checkout','CheckoutController@show');
    Route::post('add_shipping','ShippingController@addAjax');
    Route::post('apply_coupon','CouponController@applyApi');
    Route::get('shipping/{shipping}','ShippingController@showApi');
    Route::post('store_review/{product}','ReviewController@storeFromWeb');
    Route::post('personal_change','UserController@updatePersonal');
    Route::post('order','OrderController@orderWebsite')->name('order_web');
    Route::get('finished_order','OrderController@finishedOrder');
    Route::get('personal','PersonalController@viewPage');
    Route::get('favorites','PersonalController@favorites');
    Route::get('logout','UserController@logoutWeb');
    Route::get('delete-shipping/{shipping}','ShippingController@ajaxDelete');

});

Route::group(['middleware'=>'guest'],function () {
    Route::get('sign','HomeController@signView');
});
Route::get('testing','SearchController@webSearch');

//Route::get('/home', 'HomeController@index')->name('home');
