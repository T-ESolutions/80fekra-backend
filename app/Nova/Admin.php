<?php

namespace App\Nova;

use App\Nova\Actions\UserActive;
use App\Nova\Actions\UserUnActive;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;

class Admin extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    public static $priority = 8;
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'f_name';
//    public static function icon()
//    {
//        // Assuming you have a blade file containing an image
//        // in resources/views/vendor/nova/svg/icon-user.blade.php
//        return view('nova::svg.icon-user')->render();
//    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'f_name', 'l_name', 'email', 'phone', 'whats_app',
    ];



    public static function label()
    {
        return "المديرين";
    }

    public static function singularLabel()
    {
        return "المديرين";
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
            // ID::make(__('ID'), 'id')->sortable(),
            Image::make('صورة', 'image')->squared()->disk('public')->maxWidth(200)->creationRules('nullable', 'image')->updateRules('nullable', 'image'),

            Text::make('الاسم الاول', 'f_name')->rules('required')->sortable(),
            Text::make('الاسم الاخير', 'l_name')->rules('required')->sortable(),
            Text::make('البريد الالكتروني', 'email')->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            Number::make('رقم الهاتف', 'phone')->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:users,phone')
                ->updateRules('unique:users,phone,{{resourceId}}'),
            Number::make('الواتس اب', 'whats_app')->sortable()
                ->rules('required', 'max:255')
                ->creationRules('unique:users,whats_app')
                ->updateRules('unique:users,whats_app,{{resourceId}}'),
            Toggle::make('مفعل', 'is_active')->hideFromIndex()->hideFromDetail()
                ->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("مفعل", 'is_active')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            Password::make('كلمة المرور', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6')->onlyOnForms(),
            PasswordConfirmation::make('تاكيد كلمة المرور')->rules('same:password')->onlyOnForms(),

            Select::make('النوع', 'type')->options([
                \App\Models\User::ADMIN => 'مدير',
                \App\Models\User::EMPLOYEE => 'موظف',
            ])
                ->displayUsingLabels()
                ->default(\App\Models\User::EMPLOYEE),

            BelongsTo::make('المدينة', 'country', Country::class)->rules('required'),
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


    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', '!=', "user");
    }
}
