<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attribute\AttributeDestroyRequest;
use App\Http\Requests\Attribute\AttributeListRequest;
use App\Http\Requests\Attribute\AttributeShowRequest;
use App\Http\Requests\Attribute\AttributeStoreRequest;
use App\Http\Requests\Attribute\AttributeUpdateRequest;
use App\Http\Resources\AttributeCollectionResource;
use App\Http\Resources\AttributeResource;
use App\Services\AttributeService;
use App\Services\TemplateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AttributesController extends Controller
{
    /**
     * @var AttributeService
     */
    protected $service;

    /**
     * AttributesController constructor.
     * @param AttributeService $service
     */
    public function __construct(AttributeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param AttributeStoreRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\FailedAttributeCreateException
     * @throws \App\Exceptions\InvalidAttributeDataStructureException
     * @throws \App\Exceptions\InvalidAttributeTypeException
     */
    public function store(AttributeStoreRequest $request)
    {
        $attribute = $this->service->create($request->all());

        return (new AttributeResource($attribute, $this->service))->response()->setStatusCode(201);
    }

    /**
     * @param AttributeShowRequest $request
     * @param integer $id
     * @return AttributeResource
     */
    public function show(AttributeShowRequest $request, int $id)
    {
        return new AttributeResource($request->model(), $this->service);
    }

    /**
     * @param AttributeUpdateRequest $request
     * @param integer $id
     * @return AttributeResource
     * @throws \App\Exceptions\FailedAttributeCreateException
     * @throws \App\Exceptions\InvalidAttributeDataStructureException
     * @throws \App\Exceptions\InvalidAttributeTypeException
     */
    public function update(AttributeUpdateRequest $request, int $id)
    {
        $attribute = $this->service->update($id, $request->filtered());
        return new AttributeResource($attribute, $this->service);
    }

    /**
     * @param AttributeDestroyRequest $request
     * @param integer $id
     * @return JsonResponse
     * @throws \App\Exceptions\FailedAttributeDeleteException
     */
    public function destroy(AttributeDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
