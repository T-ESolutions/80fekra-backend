<?php

namespace App\Nova;

use App\Nova\Actions\OrderStatus;
use Armincms\Json\Json;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use SimpleSquid\Nova\Fields\Enum\Enum;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $priority = 4;
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return "الطلبات";
    }

    public static function singularLabel()
    {
        return "الطلبات";
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('المستخدم', 'user', User::class)->rules('required'),
//            Text::make('العنوان', 'address')->rules('required'),
//            Textarea::make('كوبون الخصم', 'coupon')->rules('nullable'),

            Json::make("address", [
                Select::make(__("Discount Type"), "type")
                    ->options([
                        'percent' => "نسبة",
                        'amount' => "مبلغ",
                    ])->displayUsingLabels()->rules('required')->default('percent'),
                Number::make(__("Discount Value"), "value")
                    ->rules("min:0")
                    ->withMeta([
                        'min' => 0
                    ]),
            ]),
            Number::make('الاجمالي الفرعي', 'subtotal')->rules('required', 'min:0'),
            Number::make('قيمة الخصم', 'discount')->rules('required', 'min:0'),
            Number::make('سعر الشحن', 'shipping_cost')->rules('required', 'min:0'),
            Number::make('الاجمالي', 'total')->rules('required', 'min:0'),
            Select::make('حالة الدفع', 'payment_status')
                ->options(['paid' => 'مدفوع', 'not_paid' => 'لم يتم الدفع'])
                ->displayUsingLabels(),
            Select::make('طريقة الدفع', 'payment_type')
                ->options(['cash' => 'كاش', 'visa' => 'فيزا'])
                ->displayUsingLabels(),
            Select::make('حالة الطلب', 'status')
                ->options([
                    'pending' => 'طلب جديد', 'on_progress' => 'جاري التجهيز',
                    'shipped' => 'تم الشحن', 'delivered' => 'تم التوصيل', 'rejected' => 'مرفوض',
                    'canceled_by_user' => 'تم الالغاء عن طريق المستخدم',
                    'canceled_by_admin' => 'تم الالغاء عن طريق الادمن'
                ])
                ->displayUsingLabels(),
            HasMany::make('منتجات الطلب', 'orderDetails', OrderDetail::class),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            OrderStatus::make()
                ->confirmText('هل انت متأكد ؟')
                ->confirmButtonText('نعم')
                ->cancelButtonText("لا"),
        ];
    }
}
