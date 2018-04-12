<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\Attribute\IAttributeCreateService;
use App\Contracts\Services\Attribute\IAttributeDeleteService;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Contracts\Services\Attribute\IAttributeListService;
use App\Http\Requests\Attribute\AttributeStoreRequest;
use App\Http\Resources\AttributeResource;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index(IAttributeListService $attributeListService)
    {
        $attributes = $attributeListService->list();

        return (AttributeResource::collection($attributes))->response()->setStatusCode(200);
    }

    public function store(AttributeStoreRequest $request, IAttributeCreateService $attributeCreateService, $templateId)
    {
        $attribute = $attributeCreateService->create($request->getEntity(), $templateId);

        return (new AttributeResource($attribute))->response()->setStatusCode(201);
    }

    public function show($id, IAttributeGetService $attributeGetService)
    {
        $attribute = $attributeGetService->get($id);

        return (new AttributeResource($attribute))->response()->setStatusCode(200);
    }

//    public function update(TagUpdateRequest $request, ITagUpdateService $tagUpdateService, int $id)
//    {
//        $tag = $tagUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());
//
//        return (new TagResource($tag))->response()->setStatusCode(200);
//    }

    public function destroy(IAttributeDeleteService $attributeDeleteService, $id)
    {
        $attributeDeleteService->delete($id);

        return response('', 204);
    }
}
