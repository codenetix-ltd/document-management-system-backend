<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class APIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @return array
     */
    protected function filterOnNull($data)
    {
        return array_filter($data, function($value)
        {
            return ($value !== null);
        });
    }
}
