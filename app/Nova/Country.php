<?php

namespace App\Nova;

use BayAreaWebPro\NovaFieldCkEditor\CkEditor;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Laravel\Nova\Fields\Boolean;

class Country extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Country::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public static $priority = 1;
    public function title()
    {
        return $this->title_ar . ' , ' . $this->title_en;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title_ar', 'title_en',
    ];

    public static function label()
    {
        return "المدن";
    }

    public static function singularLabel()
    {
        return "المدن";
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
            Text::make('الاسم بالعربية', 'title_ar')->rules('required')->sortable(),
            Text::make('الاسم بالانجليزية', 'title_en')->rules('required')->sortable(),
            Number::make('تكلفة الشحن', 'shipping_cost')->rules('required')->sortable(),
            Toggle::make('مفعل', 'is_active')->hideFromIndex()->hideFromDetail()->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("مفعل", 'is_active')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating()
            ,
            HasMany::make("المستخدمين", 'users', User::class),
            HasMany::make("العناوين", 'addresses', User::class),

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


    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->when(empty($request->get('orderBy')), function ($q) {
            $q->getQuery()->orders = [];
            return $q->orderBy(static::$model::orderColumnName());
        });

        return $query;
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Support\Collection $fields
     *
     * @return array
     */
    public function serializeForIndex(NovaRequest $request, $fields = null)
    {
        return array_merge(parent::serializeForIndex($request, $fields), [
            'sortable' => true
        ]);
    }

    public static function orderColumnName(): string
    {
        return 'sort_order';
    }

}
