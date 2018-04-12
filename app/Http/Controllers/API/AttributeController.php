<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\Attribute\IAttributeCreateService;
use App\Http\Requests\Attribute\AttributeStoreRequest;
use App\Http\Resources\AttributeResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
        //
    }

    public function store(AttributeStoreRequest $request, IAttributeCreateService $attributeCreateService, $templateId)
    {
        $attribute = $attributeCreateService->create($request->getEntity(), $templateId);

        return (new AttributeResource($attribute))->response()->setStatusCode(201);
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
