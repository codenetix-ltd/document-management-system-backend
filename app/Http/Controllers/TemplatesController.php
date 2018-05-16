<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplateCreateRequest;
use App\Http\Requests\TemplateUpdateRequest;
use App\Http\Resources\TemplateResource;
use App\Services\TemplateService;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $templates = $this->service->list();
        return TemplateResource::collection($templates);
    }

    /**
     * @param TemplateCreateRequest $request
     * @return TemplateResource
     */
    public function store(TemplateCreateRequest $request)
    {
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
        return new TemplateResource($template);
    }

    /**
     * @param TemplateUpdateRequest $request
     * @param $id
     * @return TemplateResource
     */
    public function update(TemplateUpdateRequest $request, $id)
    {
        $template = $this->service->update($request->all(), $id);
        return new TemplateResource($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
