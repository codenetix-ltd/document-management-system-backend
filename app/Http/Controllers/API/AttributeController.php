<?php

namespace App\Http\Controllers\API;

use App\Exceptions\FailedAttributeCreateException;
use App\Exceptions\InvalidAttributeDataStructureException;
use App\Exceptions\InvalidAttributeTypeException;
use App\Http\Requests\Attribute\AttributeStoreRequest;
use App\Http\Resources\AttributeResource;
use App\Http\Controllers\Controller;
use App\Services\Attribute\AttributeTransactionService;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    public function index(AttributeTransactionService $attributeListService)
    {
        $attributes = $attributeListService->list();

        return (AttributeResource::collection($attributes))->response()->setStatusCode(200);
    }

    /**
     * @param AttributeStoreRequest $request
     * @param AttributeTransactionService $attributeCreateService
     * @param $templateId
     *
     * @return JsonResponse
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    public function store(AttributeStoreRequest $request, AttributeTransactionService $attributeCreateService, $templateId)
    {
        $attribute = $attributeCreateService->create($request->getEntity(), $templateId);

        return (new AttributeResource($attribute))->response()->setStatusCode(201);
    }

    public function show($id, AttributeTransactionService $attributeGetService)
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

    /**
     * @param AttributeTransactionService $attributeDeleteService
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \App\Exceptions\FailedAttributeDeleteException
     */
    public function destroy(AttributeTransactionService $attributeDeleteService, $id)
    {
        $attributeDeleteService->delete($id);

        return response('', 204);
    }
}
