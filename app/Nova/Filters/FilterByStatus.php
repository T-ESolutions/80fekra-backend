<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class FilterByStatus extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
             'طلب جديد'=>'pending',
             'جاري التجهيز'=>'on_progress',
             'تم الشحن'=>'shipped',
             'تم التوصيل'=>'delivered',
             'مرفوض'=>'rejected',
             'تم الالغاء عن طريق المستخدم'=>'canceled_by_user',
             'تم الالغاء عن طريق الادمن'=>'canceled_by_admin'
        ];
    }

    public function name()
    {
        return 'فلتر بحالة الطلب';
    }
}
