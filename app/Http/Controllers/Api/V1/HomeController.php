<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface;
use App\Http\Requests\V1\User\Product\AddReviewRequest;
use App\Http\Requests\V1\User\Product\productByCategoryRequest;
use App\Http\Requests\V1\User\Product\ProductDetailsRequest;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    protected $homeRepo;

    public function __construct(HomeRepositoryInterface $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    public function home(Request $request)
    {
        $data = $this->homeRepo->home($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function productDetails(ProductDetailsRequest $request)
    {
        $data = $this->homeRepo->productDetails($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function productRelated(ProductDetailsRequest $request)
    {
        $data = $this->homeRepo->productRelated($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function productByCategory(productByCategoryRequest $request)
    {
        $request = $request->validated();
        $data = $this->homeRepo->productByCategory($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function AddReview(AddReviewRequest $request)
    {
        $request = $request->validated();
        $data = $this->homeRepo->AddReview($request);
        if ($data == false) {
            return response()->json(msg(failed(), trans('lang.rate_added_before')));

        }
        return response()->json(msg(success(), trans('lang.added_s_wait_approved')));
    }

    public function settings(Request $request)
    {
        $data = $this->homeRepo->settings($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

}
