<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface;
use App\Http\Controllers\Interfaces\V1\ProductRepositoryInterface;
use App\Http\Requests\V1\User\Product\AddReviewRequest;
use App\Http\Requests\V1\User\Product\productByCategoryRequest;
use App\Http\Requests\V1\User\Product\ProductDetailsRequest;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    protected $targetRepo;

    public function __construct(ProductRepositoryInterface $targetRepo)
    {
        $this->targetRepo = $targetRepo;
    }

    public function productDetails(ProductDetailsRequest $request)
    {
        $data = $this->targetRepo->productDetails($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function productRelated(ProductDetailsRequest $request)
    {
        $data = $this->targetRepo->productRelated($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function productByCategory(productByCategoryRequest $request)
    {
        $request = $request->validated();
        $data = $this->targetRepo->productByCategory($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function AddReview(AddReviewRequest $request)
    {
        $request = $request->validated();
        $data = $this->targetRepo->AddReview($request);
        if ($data == false) {
            return response()->json(msg(failed(), trans('lang.rate_added_before')));
        }
        return response()->json(msg(success(), trans('lang.added_s_wait_approved')));
    }


}
