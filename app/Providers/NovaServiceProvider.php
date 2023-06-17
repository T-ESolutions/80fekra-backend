<?php

namespace App\Providers;

use Anaseqal\NovaSidebarIcons\NovaSidebarIcons;
use App\Nova\Address;
use App\Nova\Admin;
use App\Nova\Category;
use App\Nova\Country;
use App\Nova\Metrics\OrderPerProduct;
use App\Nova\Page;
use App\Nova\City;
use App\Nova\Coupon;
use App\Nova\CouponUsage;
use App\Nova\Metrics\NewOrder;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\OrderPerStatus;
use App\Nova\Metrics\OrdersPerDay;
use App\Nova\Order;
use App\Nova\OrderDetail;
use App\Nova\Product;
use App\Nova\ProductImage;
use App\Nova\ProductReview;
use App\Nova\Setting;
use App\Nova\Slider;
use App\Nova\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Coroowicaksono\ChartJsIntegration\StackedChart;

//use Silvanite\NovaToolPermissions\NovaToolPermissions;

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
////            return in_array($user->email, [
////                //
////            ]);
//
            return $user->type == "user" ? false : true;
        });
    }


    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        $order_completed = [];
        for ($x = 1; $x <= 12; $x++) {
            $order = \App\Models\Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', '=', $x)->where('status', \App\Models\Order::STATUS_DELIVERED)->count();
            array_push($order_completed, $order);
        }

        $order_not_completed = [];
        for ($x = 1; $x <= 12; $x++) {
            $order = \App\Models\Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', '=', $x)->where('status', '!=', \App\Models\Order::STATUS_DELIVERED)->count();
            array_push($order_not_completed, $order);
        }


        $users = [];
        for ($x = 1; $x <= 12; $x++) {
            $order = \App\Models\User::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', '=', $x)->where('type', 'user')->count();
            array_push($users, $order);
        }

        return [


            (new StackedChart())
                ->title('الطلبيات')
                ->animations([
                    'enabled' => true,
                    'easing' => 'easeinout',
                ])
                ->series(array(
                    [
                        'barPercentage' => 0.8,
                        'label' => 'الطلبات المكتملة',
                        'backgroundColor' => '#6E0572',
                        'data' => $order_completed,
                    ],
                    [
                        'barPercentage' => 0.8,
                        'label' => 'الطلبات الغير مكتملة',
                        'backgroundColor' => 'red',
                        'data' => $order_not_completed,
                    ]
                ))
                ->options([
                    'xaxis' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']
                    ],
                ])
            //->width('3/4')
            ,

            new OrdersPerDay(),
            new OrderPerStatus(),
            new OrderPerProduct(),
            new NewOrder(),
            new NewUsers(),
            (new StackedChart())
                ->title('المستخدمين')
                ->animations([
                    'enabled' => true,
                    'easing' => 'easeinout',
                ])
                ->series(array([
                    'barPercentage' => 0.8,
                    'label' => 'المستخدمين',
                    'backgroundColor' => 'green',
                    'data' => $users,
                ],
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
            //   new \Runline\ProfileTool\ProfileTool,
            new NovaSidebarIcons,
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
            Page::class,
//            City::class,
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
