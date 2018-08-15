<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attribute\AttributeListRequest;
use App\Http\Requests\Template\TemplateDestroyRequest;
use App\Http\Requests\Template\TemplateShowRequest;
use App\Http\Requests\Template\TemplateListRequest;
use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Resources\AttributeCollectionResource;
use App\Http\Resources\TemplateCollectionResource;
use App\Http\Resources\TemplateResource;
use App\Services\AttributeService;
use App\Services\TemplateService;
use Illuminate\Http\Response;

class TemplatesController extends Controller
{
    /**
     * @var TemplateService
     */
    protected $service;

    /**
     * @var AttributeService
     */
    protected $attributeService;

    /**
     * TemplatesController constructor.
     * @param TemplateService  $service
     * @param AttributeService $attributeService
     */
    public function __construct(TemplateService $service, AttributeService $attributeService)
    {
        $this->service = $service;
        $this->attributeService = $attributeService;
    }

    /**
     * @param TemplateListRequest $request
     * @return TemplateCollectionResource
     */
    public function index(TemplateListRequest $request)
    {
        $templates = $this->service->paginate($request->queryParamsObject());

        return new TemplateCollectionResource($templates);
    }

    /**
     * @param AttributeListRequest $request
     * @param AttributeService $attributesService
     * @param integer $templateId
     * @return AttributeCollectionResource
     */
    public function attributes(AttributeListRequest $request, AttributeService $attributesService, int $templateId)
    {
        $attributes = $attributesService->paginateAttributes($request->queryParamsObject(), $templateId);

        return (new AttributeCollectionResource($attributes, $attributesService));
    }

    /**
     * @param TemplateStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TemplateStoreRequest $request)
    {
        $template = $this->service->create($request->all());
        return (new TemplateResource($template))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param TemplateShowRequest $request
     * @param integer $id
     * @return TemplateResource
     */
    public function show(TemplateShowRequest $request, int $id)
    {
        return new TemplateResource($request->model());
    }

    /**
     * @param TemplateUpdateRequest $request
     * @param integer               $id
     * @return TemplateResource
     */
    public function update(TemplateUpdateRequest $request, int $id)
    {
        //@TODO what a hell...
        if ($request->get('orderOfAttributes')) {
            $this->attributeService->updateOrderOfAttributes($request->get('orderOfAttributes'));
        }

        $template = $this->service->update($request->all(), $id);
        return new TemplateResource($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TemplateDestroyRequest $request
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemplateDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
