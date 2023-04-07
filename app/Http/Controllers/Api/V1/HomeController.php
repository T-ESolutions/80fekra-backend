<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface;
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

}
