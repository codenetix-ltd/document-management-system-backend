<?php

namespace App\Http\Controllers\API;

use App\Factory;
use Illuminate\Http\Request;
use DB;

class FactoryController extends APIController
{
    public function getList(Request $request)
    {
        $query = Factory::where('name', 'LIKE', $request->query->get('query') . '%');

        return json_encode($query->get()->toArray());
    }
}
