<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Http\Resources\LabelResource;
use App\Services\LabelService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class LabelsController extends Controller
{
    /**
     * @var LabelService
     */
    protected $service;

    /**
     * LabelsController constructor.
     * @param LabelService $service
     */
    public function __construct(LabelService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $labels = $this->service->list();
        return LabelResource::collection($labels);
    }

    /**
     * @param LabelCreateRequest $request
     * @return LabelResource
     */
    public function store(LabelCreateRequest $request)
    {
        $label = $this->service->create($request->all());
        return new LabelResource($label);
    }

    /**
     * @param $id
     * @return LabelResource
     */
    public function show($id)
    {
        $label = $this->service->find($id);
        return new LabelResource($label);
    }

    /**
     * @param LabelUpdateRequest $request
     * @param $id
     * @return LabelResource
     */
    public function update(LabelUpdateRequest $request, $id)
    {
        $label = $this->service->update($request->all(), $id);
        return new LabelResource($label);
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
