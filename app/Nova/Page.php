<?php

namespace App\Nova;

use BayAreaWebPro\NovaFieldCkEditor\CkEditor;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_ar';

    public static $priority = 10;

    public function title()
    {
        return $this->title_ar;
    }

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
        return "الصفحات";
    }

    public static function singularLabel()
    {
        return "الصفحات";
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
            Image::make('الصورة', 'image')->squared()->disk('public')->maxWidth(200)->creationRules('required', 'image')->updateRules('nullable', 'image'),
            Text::make('الاسم بالعربية', 'title_ar')->rules('required')->sortable(),
            Text::make('الاسم بالانجليزية', 'title_en')->rules('required')->sortable(),
            CkEditor::make('المحتوى بالعربية', 'body_ar')
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
            CkEditor::make('المحتوى بالانجليزية', 'body_ar')
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
