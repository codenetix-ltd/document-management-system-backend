<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateCreateRequest;
use App\Http\Requests\TemplateUpdateRequest;
use App\Http\Resources\TemplateCollectionResource;
use App\Http\Resources\TemplateResource;
use App\Services\TemplateService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class TemplatesController extends Controller
{
    /**
     * @var TemplateService
     */
    protected $service;

    /**
     * TemplatesController constructor.
     * @param TemplateService $service
     */
    public function __construct(TemplateService $service)
    {
        $this->service = $service;
    }

    /**
     * @return TemplateCollectionResource
     */
    public function index()
    {
        $templates = $this->service->paginate();
        return  new TemplateCollectionResource($templates);
    }

    /**
     * @param TemplateCreateRequest $request
     * @return TemplateResource
     */
    public function store(TemplateCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('template');
        $authorizer->authorize('template_create');

        $template = $this->service->create($request->all());
        return new TemplateResource($template);
    }

    /**
     * @param $id
     * @return TemplateResource
     */
    public function show($id)
    {
        $template = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('template', $template);
        $authorizer->authorize('template_view');

        return new TemplateResource($template);
    }

    /**
     * @param TemplateUpdateRequest $request
     * @param $id
     * @return TemplateResource
     */
    public function update(TemplateUpdateRequest $request, $id)
    {
        $template = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('template', $template);
        $authorizer->authorize('template_update');

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
    public function destroy($id)
    {
        $template = $this->service->findModel($id);

        if ($template) {
            $authorizer = AuthorizerFactory::make('template', $template);
            $authorizer->authorize('template_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
