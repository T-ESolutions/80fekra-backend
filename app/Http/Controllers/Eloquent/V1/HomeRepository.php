<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface;
use App\Http\Resources\V1\CategoryCustomResources;
use App\Http\Resources\V1\CategoryResources;
use App\Http\Resources\V1\CountriesResources;
use App\Http\Resources\V1\ProductResources;
use App\Http\Resources\V1\ProductReviewsResources;
use App\Http\Resources\V1\SettingResources;
use App\Http\Resources\V1\SliderResources;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\ProductReview;
use JWTAuth;

class HomeRepository implements HomeRepositoryInterface
{

    public function home($request)
    {
        $data['sliders'] = (SliderResources::collection(Slider::active()->orderBy('sort_order', 'asc')->get()));
        $data['categories'] = (CategoryResources::collection(Category::active()->orderBy('sort_order', 'asc')->get()));
        $data['products'] = (ProductResources::collection(Product::active()->home()->orderBy('sort_order', 'asc')->get()->take(8)));
        return $data;
    }

    public function productDetails($request)
    {
        $data['product'] = new ProductResources(Product::active()->whereId($request['id'])->first());
        $reviews = ProductReview::approval()->where('product_id', $request['id'])->orderBy('created_at', 'desc')->paginate(Config('app.paginate'));
        $data['reviews'] = (ProductReviewsResources::collection($reviews))->response()->getData(true);
        return $data;
    }

    public function productByCategory($request)
    {

//        $sections = Section::select('id','name_'.$lang .' as title','image')->get()->makeHidden('name')->toArray();
        $categories = Category::active()->orderBy('sort_order', 'asc')->get();



        $categories = (CategoryCustomResources::customCollection($categories, $request));

//        // add all categories in sections ....
//        $all = [
//            'id' => 0,
//            'image' => "",
//            'title' =>   trans('lang.all_categories'),
//            'selected' => 0,
//        ];
//        array_unshift($categories, $all);
        $data['categories'] = $categories ;
        $products = Product::Query();
        if (isset($request['category_id'])) {
            $products = $products->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request['category_id']);
            });
        } else {
            $products = $products->whereHas('categories');
        }
        $products = $products->active()->paginate(Config('app.paginate'));
        $data['products'] = (ProductResources::collection($products))->response()->getData(true);
        return $data;
    }

    public function AddReview($request)
    {
        //check if this first address or not
        $exists_rate = ProductReview::where('user_id', JWTAuth::user()->id)->where('product_id', $request['product_id'])->first();
        if ($exists_rate) {
            return false;
        }
        $request['user_id'] = JWTAuth::user()->id;
        $data = ProductReview::create($request);
        return $data;
    }

    public function settings($request)
    {
        $data = (SettingResources::collection(Setting::orderBy('created_at', 'asc')->get()));

        return $data;
    }

}
