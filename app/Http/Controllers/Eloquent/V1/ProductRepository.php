<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1;

use App\Http\Controllers\Interfaces\V1\ProductRepositoryInterface;
use App\Http\Resources\V1\CategoryCustomResources;
use App\Http\Resources\V1\ProductResources;
use App\Http\Resources\V1\ProductReviewsResources;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use JWTAuth;
use League\Flysystem\Config;

class ProductRepository implements ProductRepositoryInterface
{


    public function productDetails($request)
    {
        $data['product'] = new ProductResources(Product::active()->whereId($request['id'])->first());
        $reviews = ProductReview::approval()->where('product_id', $request['id'])->orderBy('created_at', 'desc')->paginate(Config('app.paginate'));

        $rates_one = ProductReview::approval()->where('product_id', $request['id'])->where('rate', 1)->get()->count();
        $rates_tow = ProductReview::approval()->where('product_id', $request['id'])->where('rate', 2)->get()->count();
        $rates_three = ProductReview::approval()->where('product_id', $request['id'])->where('rate', 3)->get()->count();
        $rates_four = ProductReview::approval()->where('product_id', $request['id'])->where('rate', 4)->get()->count();
        $rates_five = ProductReview::approval()->where('product_id', $request['id'])->where('rate', 5)->get()->count();

        $data['reviews_count'][] = ['five' => $rates_five];
        $data['reviews_count'][] = ['four' => $rates_four];
        $data['reviews_count'][] = ['three' => $rates_three];
        $data['reviews_count'][] = ['tow' => $rates_tow];
        $data['reviews_count'][] = ['one' => $rates_one];

        $data['reviews'] = (ProductReviewsResources::collection($reviews))->response()->getData(true);
        return $data;
    }

    public function productRelated($request)
    {
        $main_product = Product::whereId($request['id'])->active()->first();
        $product_categories = $main_product->categories->toArray('category_id');
        $products = Product::where('id', '!=', $request['id'])->active()->whereHas('categories', function ($q) use ($product_categories) {
            $q->whereIn('category_id', $product_categories);
        })->paginate(Config('app.paginate'));
        $data = ProductResources::collection($products)->response()->getData(true);
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
        $data['categories'] = $categories;
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
        if (Config('app.env') == 'local') {
            $request['is_approved'] = 1;
        }
        $data = ProductReview::create($request);
        return $data;
    }


}
