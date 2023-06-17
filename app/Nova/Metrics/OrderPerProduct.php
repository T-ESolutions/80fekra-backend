<?php

namespace App\Nova\Metrics;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class OrderPerProduct extends Partition
{
    public function name()
    {
        return 'الطلبات بالمنتجات';
    }
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, OrderDetail::class, 'product_id')
            ->label(function ($value){
                if ($value === null) {
                    return 'None';
                }
                $product = Product::find($value);
                return $product ? $product->title_ar : 'غير موجود';
            });


    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'order-per-product';
    }
}
