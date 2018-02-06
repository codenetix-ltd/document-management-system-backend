<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Attribute\AttributeStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
        //
    }

    public function store(AttributeStoreRequest $request, $templateId)
    {
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
