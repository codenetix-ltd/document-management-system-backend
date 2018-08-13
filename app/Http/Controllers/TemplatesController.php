<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateCreateRequest;
use App\Http\Requests\TemplateListRequest;
use App\Http\Requests\TemplateUpdateRequest;
use App\Http\Resources\TemplateCollectionResource;
use App\Http\Resources\TemplateResource;
use App\Services\AttributeService;
use App\Services\TemplateService;
use App\System\AuthBuilders\AuthorizerFactory;
use Exception;
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
     * @param TemplateCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TemplateCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('template');
        $authorizer->authorize('template_create');

        $template = $this->service->create($request->all());
        return (new TemplateResource($template))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param integer $id
     * @return TemplateResource
     */
    public function show(int $id)
    {
        $template = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('template', $template);
        $authorizer->authorize('template_view');

        return new TemplateResource($template);
    }

    /**
     * @param TemplateUpdateRequest $request
     * @param integer               $id
     * @return TemplateResource
     */
    public function update(TemplateUpdateRequest $request, int $id)
    {
        $template = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('template', $template);
        $authorizer->authorize('template_update');

        if ($request->get('orderOfAttributes')) {
            $this->attributeService->updateOrderOfAttributes($id, $request->get('orderOfAttributes'));
        }

        $template = $this->service->update($request->all(), $id);
        return new TemplateResource($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $template = $this->service->find($id);
        } catch (Exception $e) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        if ($template) {
            $authorizer = AuthorizerFactory::make('template', $template);
            $authorizer->authorize('template_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
