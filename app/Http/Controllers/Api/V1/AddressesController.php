<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Requests\V1\User\AddressRequest;
use Illuminate\Http\Request;


class AddressesController extends Controller
{
    protected $targetRepo;

    public function __construct(AddressesRepositoryInterface $targetRepo)
    {
        $this->targetRepo = $targetRepo;
    }

    public function index(Request $request)
    {
        $data = $this->targetRepo->index($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function store(AddressRequest $request)
    {
        $request = $request->validated();
        $data = $this->targetRepo->store($request);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

}
