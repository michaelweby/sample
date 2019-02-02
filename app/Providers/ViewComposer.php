<?php

namespace App\Providers;

use App\Cart;
use App\Category;
use App\Setting;
use App\User;
use Illuminate\Support\ServiceProvider;

class ViewComposer extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->navCategories();

        $this->navCart();

        $this->favorites();

        $this->baseInfo();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function navCategories()
    {
        view()->composer('website.components.header', function ($view) {
            $view->with('categories', Category::where('parent_id', 0)->get());
        });
    }

    public function navCart()
    {
        view()->composer('website.components.header', function ($view) {
            $view->with('cart_count', Cart::countItems());
        });
    }
    public function favorites()
    {
        view()->composer('website.components.header', function ($view) {
            $view->with('favorites_count', User::favourites());
        });
    }
    public function baseInfo()
    {
        view()->composer(['website.components.header','website.components.footer','website.about','website.contact'], function ($view) {
            $view->with('base_info', Setting::first());
        });
    }
}
