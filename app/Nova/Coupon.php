<?php

namespace App\Nova;

use App\Nova\Actions\UserActive;
use App\Nova\Actions\UserUnActive;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;

class Coupon extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Coupon::class;

    public static $priority = 9;
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    public static function label()
    {
        return "كوبونات الخصم";
    }

    public static function singularLabel()
    {
        return "كوبونات الخصم";
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
        'discount',
        'type',
        'start_date',
        'end_date',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('كود الخصم', 'code')->rules('required')->sortable(),
            Select::make('نوع الخصم', 'type')->options([
                  \App\Models\Coupon::PERCENTAGE => 'نسبة %',
                \App\Models\Coupon::AMOUNT => 'مبلغ $',
            ])->displayUsingLabels()->default( \App\Models\Coupon::PERCENTAGE),

            Number::make('الخصم', 'discount')->rules('required')->sortable(),
            Text::make('عدد الاستخدامات ', 'usage_count')->hideWhenCreating()->hideWhenUpdating()->sortable(),
            Date::make('تاريخ البدء', 'start_date')->rules('required')->sortable(),
            Date::make('تاريخ النهاية', 'end_date')->rules('required','after:start_date')->sortable(),
            Toggle::make('مفعل', 'is_active')->hideFromIndex()->hideFromDetail()
                ->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("مفعل", 'is_active')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            HasMany::make("استخدامات الكوبون", 'couponUsage', CouponUsage::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            UserActive::make()
                ->confirmText('هل انت متأكد من التفعيل؟')
                ->confirmButtonText('تفعيل')
                ->cancelButtonText("لا"),
            UserUnActive::make()
                ->confirmText('هل انت متأكد من الغاء التفعيل؟')
                ->confirmButtonText('الغاء التفعيل')
                ->cancelButtonText("لا"),
        ];
    }
}
