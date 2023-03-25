<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Nikaia\Rating\Rating;

class ProductReview extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProductReview::class;

    public static $displayInNavigation = false;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
        return "تقييمات المنتج";
    }

    public static function singularLabel()
    {
        return "تقييمات المنتج";
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
            BelongsTo::make('المنتج', 'product', Product::class)->readonly()->rules('required'),
            BelongsTo::make('المستخدم', 'user', User::class)->readonly()->rules('required'),
            Textarea::make('التعليق', 'comment')->readonly()->rules('required'),
            Rating::make('التقييم', 'rate')->withStyles([
                'star-size' => 30,
                'active-color' => 'var(--warning)', // Primary nova theme color.
                'inactive-color' => '#d8d8d8',
                'border-color' => 'var(--60)',
                'border-width' => 0,
                'padding' => 10,
                'rounded-corners' => false,
                'inline' => false,
                'glow' => 0,
                'glow-color' => '#fff',
                'text-class' => 'inline-block text-80 h-9 pt-2',
            ])->min(0)->max(5)->increment(1)->readonly()->rules('required'),
            Toggle::make('الموافقة من الادمن', 'is_approved')->hideFromIndex()->hideFromDetail()
                ->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("الموافقة من الادمن", 'is_approved')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating()        ];
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
