<?php

namespace App\Http\Controllers\API;

use App\Template;
use Illuminate\Http\Request;
use DB;

class TemplateController extends APIController
{
    public function getList(Request $request)
    {
        $query = Template::where('name', 'LIKE', $request->query->get('query') . '%');

        return json_encode($query->get()->toArray());
    }
}
