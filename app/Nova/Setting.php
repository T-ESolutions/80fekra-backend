<?php

namespace App\Nova;

use BayAreaWebPro\NovaFieldCkEditor\CkEditor;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Pdmfc\NovaFields\InlineText;

class Setting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Setting::class;

    public static $priority = 11;
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'key';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'key',
        'value',
    ];

    public static function label()
    {
        return "الاعدادات";
    }

    public static function singularLabel()
    {
        return "الاعدادات";
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
            Text::make("اسم الاعداد", 'key')->creationRules('required')->readonlyOnUpdate(),
            Text::make("القيمة", 'value')->creationRules('required'),
//            CkEditor::make('القيمة', 'value')
//                ->rules('required')
//                ->hideFromIndex()
//                ->mediaBrowser()
//                ->linkBrowser()
//                ->height(60)
//                ->stacked()
//                ->toolbar([
//                    'heading',
//                    'horizontalLine',
//                    '|',
//                    'link',
//                    'linkBrowser',
//                    '|',
//                    'bold',
//                    'italic',
//                    'alignment',
//                    'subscript',
//                    'superscript',
//                    'underline',
//                    'strikethrough',
//                    '|',
//                    'blockQuote',
//                    'bulletedList',
//                    'numberedList',
//                    '|',
//                    'insertTable',
//                    'mediaEmbed',
//                    'mediaBrowser',
//                    'insertSnippet',
//                    '|',
//                    'undo',
//                    'redo'
//                ]),
            Image::make("الصورة", 'image')->prunable(),
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
