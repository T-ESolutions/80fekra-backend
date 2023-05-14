<?php

namespace App\Nova;

use App\Nova\Actions\OrderPaymentStatus;
use App\Nova\Actions\OrderStatus;
use Armincms\Json\Json;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

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

    public static $priority = 5;
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
                    'pending' => 'طلب جديد',
                    'on_progress' => 'جاري التجهيز',
                    'shipped' => 'تم الشحن',
                    'delivered' => 'تم التوصيل',
                    'rejected' => 'مرفوض',
                    'canceled_by_user' => 'تم الالغاء عن طريق المستخدم',
                    'canceled_by_admin' => 'تم الالغاء عن طريق الادمن'
                ])
                ->displayUsingLabels(),
            new Panel('تفاصيل عنوان الطلب', $this->addressFields()),
            new Panel('تفاصيل كود الخصم', $this->couponFields()),

            HasMany::make('منتجات الطلب', 'orderDetails', OrderDetail::class),
            Text::make('اسماء المنتجات', function () {
                return $this->orderDetails->map(function ($orderDetail) {
                    return $orderDetail->product->title;
                })->implode(', ');
            }),


        ];
    }

    private function addressFields()
    {
        return [
            Json::make("address", [
                Text::make(" الاسم الاول", 'f_name')->hideFromIndex(),
                Text::make("الاسم الاخير ", 'l_name')->hideFromIndex(),
                Text::make("رقم الجوال ", 'phone')->hideFromIndex(),
                Text::make("العنوان ", 'address')->hideFromIndex(),
                Json::make("country", [
                    Text::make(" المدينة", 'title_ar')->hideFromIndex(),
                ])
            ]),

        ];

    }


    private function couponFields()
    {
        return [
            Json::make("coupon", [
                Text::make('كود الخصم', 'code')->rules('required')->sortable()->hideFromIndex(),
                Select::make('نوع الخصم', 'type')->options([
                    \App\Models\Coupon::PERCENTAGE => 'نسبة %',
                    \App\Models\Coupon::AMOUNT => 'مبلغ $',
                ])->displayUsingLabels()->hideFromIndex(),

                Number::make('الخصم', 'discount')->rules('required')->sortable()->hideFromIndex(),
//                Date::make('تاريخ البدء', 'start_date')->rules('required')->sortable()->hideFromIndex(),
//                Date::make('تاريخ النهاية', 'end_date')->rules('required', 'after:start_date')->sortable()->hideFromIndex(),

            ])
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
            OrderPaymentStatus::make()
                ->confirmText('هل انت متأكد ؟')
                ->confirmButtonText('نعم')
                ->cancelButtonText("لا"),
            (new DownloadExcel)
//                ->withFilename('Orders-' . Carbon::now()->translatedFormat("Y-m-d h:i:s a") . '.xlsx')
                ->withHeadings()
                ->askForWriterType()
                ->askForFilename()

        ];
    }


}
