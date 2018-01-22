<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use DB;

class UserController extends APIController
{
    public function getList(Request $request)
    {
        $query = User::where('full_name', 'LIKE', $request->query->get('query') . '%');

        return json_encode($query->get()->toArray());
    }
}
