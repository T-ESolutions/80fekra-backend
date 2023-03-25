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
use Coroowicaksono\ChartJsIntegration\StackedChart;

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
        $data = [];
        for($x=1; $x<=12; $x++){
            $order = \App\Models\Order::whereYear('created_at',date('Y'))
                ->whereMonth('created_at','=',$x)->count();
            array_push($data,$order);
        }

        return [

            (new StackedChart())
                ->title('الطلبيات')
                ->animations([
                    'enabled' => true,
                    'easing' => 'easeinout',
                ])
                ->series(array([
                    'barPercentage' => 0.8,
                    'label' => 'الطلبات',
                    'backgroundColor' => '#6E0572',
                    'data' => $data,
                ],
//                    [
//                    'barPercentage' => 0.8,
//                    'label' => 'الطلبات',
//                    'backgroundColor' => 'red',
//                    'data' => $data,
//                ]
                ))
                ->options([
                    'xaxis' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']
                    ],
                ])
                ->width('2/3'),

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
