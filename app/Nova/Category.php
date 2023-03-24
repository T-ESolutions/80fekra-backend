<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_ar';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title_ar', 'title_en'
    ];

    public static function label()
    {
        return "الاقسام";
    }

    public static function singularLabel()
    {
        return "الاقسام";
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
//            Image::make("صورة القسم", 'image')->creationRules('required', 'image')->updateRules('nullable', 'image'),
            Image::make('صورة القسم', 'image')->squared()->disk('public')->maxWidth(200)->creationRules('required', 'image')->updateRules('nullable', 'image'),
            Text::make('اسم القسم بالعربية', 'title_ar')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('اسم القسم بالانجليزية', 'title_en')
                ->sortable()
                ->rules('required', 'max:255'),
            Toggle::make('مفعل', 'is_active')->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),

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
