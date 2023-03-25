<?php

namespace App\Providers;

use App\Nova\Address;
use App\Nova\Admin;
use App\Nova\Category;
use App\Nova\Country;
use App\Nova\Coupon;
use App\Nova\CouponUsage;
use App\Nova\Order;
use App\Nova\OrderDetail;
use App\Nova\Product;
use App\Nova\ProductImage;
use App\Nova\ProductReview;
use App\Nova\Setting;
use App\Nova\Slider;
use App\Nova\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::sortResourcesBy(function ($resource) {
            return $resource::$priority ?? 9999;
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
           // new \Runline\ProfileTool\ProfileTool,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function resources()
    {
        Nova::resources([
            Address::class,
            Admin::class,
            Category::class,
            Country::class,
            Coupon::class,
            CouponUsage::class,
            Order::class,
            OrderDetail::class,
            Product::class,
            ProductImage::class,
            ProductReview::class,
            Setting::class,
            Slider::class,
            User::class,

        ]);
    }
}
