<?php

Route::get('web1',function (){
    dd('web1');
});

Route::group(['prefix'=>PATH],function (){
    Route::resource('category','CategoryController');
    Route::resource('shop','ShopController');
    Route::resource('product','ProductController');
    Route::resource('attribute','AttributeController');
    Route::post('additem/{id}','ProductController@additem');
    Route::get('showitem/{item2}','ProductController@showitem');
    Route::post('addattribute/{attribute}','ProductController@addattribute');
    Route::post('get_attribute_value','AjaxController@get_attribute_value');
    Route::delete('deleteattribute/{id}','ProductController@deleteattribute');
    Route::post('edititem/{item2}','ProductController@edititem');
    Route::post('delete/image','ProductController@delete_image');
    Route::delete('deleteitem/{item2}','ProductController@deleteitem');
    Route::delete('attributevalue/{value}','AttributeController@deletevalue');
    Route::put('editvalue/{value}','AttributeController@editvalue');
    Route::post('add_values/{attribute}','AttributeController@add_values');
});
