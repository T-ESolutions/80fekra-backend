<?php
/**
 * Created by PhpStorm.
 * User: Al Mohands
 * Date: 22/05/2019
 * Time: 01:52 م
 */

namespace App\Http\Controllers\Interfaces\V1;


interface HelpersRepositoryInterface
{
    public function countries($request);
    public function cities($request);
    public function pages($request);
    public function pageDetails($request);

}
