<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\HelpersRepositoryInterface;
use App\Http\Resources\V1\CountriesResources;
use Illuminate\Http\Request;


class HelpersController extends Controller
{
    protected $helpersRepo;

    public function __construct(HelpersRepositoryInterface $helpersRepo)
    {
        $this->helpersRepo = $helpersRepo;
    }

    public function countries(Request $request)
    {
        $data = $this->helpersRepo->countries($request);
        $data = (CountriesResources::collection($data))->response()->getData(true);
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

}
