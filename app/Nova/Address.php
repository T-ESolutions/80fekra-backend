<?php

namespace App\Nova;

use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;

class Address extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Address::class;

    public static $displayInNavigation = false;
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $search = [
        'address'
    ];
    public static $title = 'address';

    public static $priority = 2;

    public static function label()
    {
        return "عناوين المستخدمين";
    }

    public static function singularLabel()
    {
        return "عناوين المستخدمين";
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
            Text::make('العنوان', 'address')->rules('required')->sortable(),
            Text::make('الاسم الاول', 'f_name')->rules('required')->sortable(),
            Text::make('الاسم الاخير', 'l_name')->rules('required')->sortable(),
            Number::make('رقم الهاتف', 'phone')->sortable()
                ->rules('required', 'max:255')
            ,
            BelongsTo::make('المدينة', 'country', Country::class)->rules('required'),
            Boolean::make('العنوان الاساسي؟', 'is_default'),
//            MapMarker::make("Location")
//                ->latitude('lat')
//                ->longitude('lng')->hideFromIndex(),


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
        return [];
    }
}
