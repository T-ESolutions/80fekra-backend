<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1;


interface AddressesRepositoryInterface
{
    public function index($request);
    public function details($request);
    public function store($request);
    public function update($request);
    public function makeDefault($request);
    public function delete($request);

}
