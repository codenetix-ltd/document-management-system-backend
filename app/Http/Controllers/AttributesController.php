<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeCreateRequest;
use App\Http\Requests\AttributeListRequest;
use App\Http\Requests\AttributeUpdateRequest;
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
     * @var TemplateService
     */
    protected $templateService;

    /**
     * AttributesController constructor.
     * @param AttributeService $service
     * @param TemplateService  $templateService
     */
    public function __construct(AttributeService $service, TemplateService $templateService)
    {
        $this->service = $service;
        $this->templateService = $templateService;
    }

    /**
     * @param AttributeListRequest $request
     * @param integer $templateId
     * @return AttributeCollectionResource
     */
    public function index(AttributeListRequest $request, int $templateId)
    {
        $this->templateService->find($templateId);
        $attributes = $this->service->paginateAttributes($templateId);

        return (new AttributeCollectionResource($attributes, $this->service));
    }

    /**
     * @param integer                $templateId
     * @param AttributeCreateRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\FailedAttributeCreateException
     * @throws \App\Exceptions\InvalidAttributeDataStructureException
     * @throws \App\Exceptions\InvalidAttributeTypeException
     */
    public function store(int $templateId, AttributeCreateRequest $request)
    {
        $attribute = $this->service->create($templateId, $request->all());

        return (new AttributeResource($attribute, $this->service))->response()->setStatusCode(201);
    }

    /**
     * @param integer $templateId
     * @param integer $id
     * @return AttributeResource
     */
    public function show(int $templateId, int $id)
    {
        $this->templateService->find($templateId);
        $attribute = $this->service->find($id);
        return new AttributeResource($attribute, $this->service);
    }

    /**
     * @param integer                $templateId
     * @param integer                $id
     * @param AttributeUpdateRequest $request
     * @return AttributeResource
     * @throws \App\Exceptions\FailedAttributeCreateException
     * @throws \App\Exceptions\InvalidAttributeDataStructureException
     * @throws \App\Exceptions\InvalidAttributeTypeException
     */
    public function update(int $templateId, int $id, AttributeUpdateRequest $request)
    {
        $attribute = $this->service->update($templateId, $id, $request->getInputData());
        return new AttributeResource($attribute, $this->service);
    }

    /**
     * @param integer $templateId
     * @param integer $id
     * @return JsonResponse
     * @throws \App\Exceptions\FailedAttributeDeleteException
     */
    public function destroy(int $templateId, int $id)
    {
        $this->templateService->find($templateId);
        $this->service->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
