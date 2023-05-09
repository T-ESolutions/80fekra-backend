<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\AddressesRepositoryInterface;
use App\Http\Requests\V1\User\Address\AddressMakeDefaultRequest;
use App\Http\Requests\V1\User\Address\AddressRequest;
use App\Http\Resources\V1\AddressesResources;
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
        $data = (AddressesResources::collection($data))->response()->getData(true);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function details(AddressMakeDefaultRequest $request)
    {
        $data = $this->targetRepo->details($request);
        $data = new AddressesResources($data);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function store(AddressRequest $request)
    {
        $request = $request->validated();
        $this->targetRepo->store($request);
        return response()->json(msg(success(), trans('lang.added_s')));
    }

    public function update(AddressRequest $request)
    {
        $request = $request->validated();
        $this->targetRepo->update($request);
        return response()->json(msg(success(), trans('lang.updated_s')));
    }

    public function makeDefault(AddressMakeDefaultRequest $request)
    {
        $request = $request->validated();
        $result = $this->targetRepo->makeDefault($request);
        if ($result == false) {
            return response()->json(msg(failed(), trans('lang.should_choose_your_address')));
        }
        return response()->json(msg(success(), trans('lang.updated_s')));
    }

    public function delete(AddressMakeDefaultRequest $request)
    {
        $request = $request->validated();
        $result = $this->targetRepo->delete($request);
        if ($result == false) {
            return response()->json(msg(failed(), trans('lang.should_choose_your_address')));
        }
        return response()->json(msg(success(), trans('lang.deleted_s')));
    }


}
