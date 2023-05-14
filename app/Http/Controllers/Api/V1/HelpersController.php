<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\HelpersRepositoryInterface;
use App\Http\Requests\V1\User\CitiesRequest;
use App\Http\Resources\V1\CitiesResources;
use App\Http\Resources\V1\CountriesResources;
use App\Http\Resources\V1\PageDetailsResources;
use App\Http\Resources\V1\PagesResources;
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
        $data = (CountriesResources::collection($data));
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function cities(CitiesRequest $request)
    {
        $data = $this->helpersRepo->cities($request);
        $data = (CitiesResources::collection($data));
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function pages(Request $request)
    {
        $data = $this->helpersRepo->pages($request);
        $data = (PagesResources::collection($data));
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

    public function pageDetails(Request $request)
    {
        $data = $this->helpersRepo->pageDetails($request);
        $data = (new PageDetailsResources($data));
        return response()->json(msgdata(success(), trans('lang.success'), $data));
    }

}
