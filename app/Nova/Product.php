<?php

namespace App\Nova;

use App\Nova\Actions\UserActive;
use App\Nova\Actions\UserUnActive;
use BayAreaWebPro\NovaFieldCkEditor\CkEditor;
use Illuminate\Http\Request;
use Inspheric\Fields\Url;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Naif\Toggle\Toggle;
use Superlatif\NovaTagInput\Tags;

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
    public static $priority = 4;

    //public static $title = 'title_ar';
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
            BelongsToMany::make('الاقسام', 'productCategories', Category::class)->rules('required'),
            HasMany::make('صور المنتج', 'productImages', ProductImage::class),
            HasMany::make('تقييمات المنتج', 'productReviews', ProductReview::class),

            Text::make('اسم المنتج بالعربية', 'title_ar')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('اسم المنتج بالانجليزية', 'title_en')
                ->sortable()
                ->rules('required', 'max:255'),
            CkEditor::make('وصف مختصر للمنتج بالعربية', 'short_desc_ar')
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
            CkEditor::make('وصف مختصر للمنتج بالانجليزية', 'short_desc_en')
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
            CkEditor::make('وصف المنتج بالعربية', 'description_ar')
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
            CkEditor::make('وصف المنتج بالانجليزية', 'description_en')
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
            CkEditor::make('مواصفات المنتج بالعربية', 'attributes_ar')
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
                ]), CkEditor::make('مواصفات المنتج بالانجليزية', 'attributes_en')
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
            Url::make('رابط الفيديو', 'video_url')->rules('url', /* ... */),
            Number::make('سعر المنتج', 'price')
                ->sortable()->default(0)
                ->rules('required', 'min:0'),
            Number::make('قيمة الخصم (%)', 'discount')
                ->sortable()->default(0)
                ->rules('required', 'min:0'),

//            Tags::make( 'الكلمات المفتاحية','tags')
//                ->help("Press ENTER to add tag")
//                ->placeholder("Add a new tag")
//                ->allowEditTags(true)
//                ->addOnKeys([13, ':', ';', ',']) // 13 = Enter key
//                ->autocompleteItems([
//                    'Arizona',
//                    'California',
//                    'Colorado',
//                    'Michigan',
//                    'New York',
//                    'Texas',
//                ])->onlyOnForms(),

            Toggle::make('مفعل', 'is_active')->hideFromIndex()->hideFromDetail()
                ->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("مفعل", 'is_active')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            //            Tags::make('tags','tags'),

            Toggle::make('الظهور في الصفحة الرئيسية', 'is_home')->hideFromIndex()->hideFromDetail()
                ->default(1)->color('#7e3d2f')->onColor('#7a38eb')->offColor('#ae0f04'),
            Boolean::make("الظهور في الصفحة الرئيسية", 'is_home')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating()

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

}
