<?php

namespace App\Http\Controllers;

use App\Contracts\Services\IAuthorizeService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $authorizeService;

    public function __construct(IAuthorizeService $authorizeService)
    {
        $this->authorizeService = $authorizeService;
    }

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
