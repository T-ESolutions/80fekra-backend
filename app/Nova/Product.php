<?php

namespace App\Nova;

use BayAreaWebPro\NovaFieldCkEditor\CkEditor;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Naif\Toggle\Toggle;
use Spatie\TagsField\Tags;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    //public static $title = 'title_ar';
    public function title()
    {
        return $this->title_ar . ', ' . $this->title_en;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title_ar', 'title_en','tags'
    ];

    public static function label()
    {
        return "المنتجات";
    }

    public static function singularLabel()
    {
        return "المنتجات";
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
            Text::make('اسم المنتج بالعربية', 'title_ar')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('اسم المنتج بالانجليزية', 'title_en')
                ->sortable()
                ->rules('required', 'max:255'),
            CkEditor::make('وصف المنتج بالعربية','description_ar')
                ->rules('required')
                ->hideFromIndex()
                ->mediaBrowser()
                ->linkBrowser()
                ->height(60)
                ->stacked()

                ->toolbar([
                    'heading',
                    'horizontalLine',
                    '|',
                    'link',
                    'linkBrowser',
                    '|',
                    'bold',
                    'italic',
                    'alignment',
                    'subscript',
                    'superscript',
                    'underline',
                    'strikethrough',
                    '|',
                    'blockQuote',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'insertTable',
                    'mediaEmbed',
                    'mediaBrowser',
                    'insertSnippet',
                    '|',
                    'undo',
                    'redo'
                ]),
            CkEditor::make('وصف المنتج بالانجليزية','description_en')
                ->rules('required')
                ->hideFromIndex()
                ->mediaBrowser()
                ->linkBrowser()
                ->height(60)
                ->stacked()

                ->toolbar([
                    'heading',
                    'horizontalLine',
                    '|',
                    'link',
                    'linkBrowser',
                    '|',
                    'bold',
                    'italic',
                    'alignment',
                    'subscript',
                    'superscript',
                    'underline',
                    'strikethrough',
                    '|',
                    'blockQuote',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'insertTable',
                    'mediaEmbed',
                    'mediaBrowser',
                    'insertSnippet',
                    '|',
                    'undo',
                    'redo'
                ]),
            Number::make('سعر المنتج', 'price')
                ->sortable()->default(0)
                ->rules('required','min:0'),
            Number::make('قيمة الخصم (%)', 'discount')
                ->sortable()->default(0)
                ->rules('required','min:0'),
            Toggle::make('مفعل', 'is_active')->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Tags::make('tags','tags'),

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


}
