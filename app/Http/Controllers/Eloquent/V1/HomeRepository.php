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
        $data['products'] = (ProductResources::collection(Product::whereHas('productImages')->active()->home()->orderBy('sort_order', 'asc')->get()->take(8)));
        return $data;
    }

    public function settings($request)
    {
        $data = (SettingResources::collection(Setting::orderBy('created_at', 'asc')->get()));
        return $data;
    }

    public function setting($request ,$id)
    {
        $data = (new SettingResources(Setting::whereId($id)->first()));
        return $data;
    }

}
