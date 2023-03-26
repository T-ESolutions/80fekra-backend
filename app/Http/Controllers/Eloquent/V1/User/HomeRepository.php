<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:53 م
 */

namespace App\Http\Controllers\Eloquent\V1\User;

use App\Http\Controllers\Interfaces\V1\User\HomeRepositoryInterface;
use App\Http\Resources\V1\User\QuestionsResources;
use App\Models\Question;
use App\Models\Service;
use App\Models\ServiceCarCategory;

class HomeRepository implements HomeRepositoryInterface
{

    public function services($request)
    {
        $data = Service::active()
            ->paginate(pagination_number());
        return $data;
    }

    public function serviceQuestions($request)
    {
        $data = Question::active()
            ->where('service_id', $request->service_id)
            ->get();
        return $data;
    }

    public function calculateBrandCost($request)
    {
        $data = ServiceCarCategory::where('service_id',$request->service_id)
            ->where('brand_id', $request->brand_id)
            ->where('modell_id', $request->modell_id)
            ->where('year_id', $request->year_id)
            ->first();
        return $data;
    }


}
