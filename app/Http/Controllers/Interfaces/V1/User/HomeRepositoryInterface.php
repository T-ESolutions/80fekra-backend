<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1\User;


interface HomeRepositoryInterface
{
    public function services($request);
    public function serviceQuestions($request);
    public function calculateBrandCost($request);

}
