<?php

namespace App\Http\Controllers;

use App\Http\Requests\Label\LabelDestroyRequest;
use App\Http\Requests\Label\LabelShowRequest;
use App\Http\Requests\Label\LabelListRequest;
use App\Http\Requests\Label\LabelStoreRequest;
use App\Http\Requests\Label\LabelUpdateRequest;
use App\Http\Resources\LabelCollectionResource;
use App\Http\Resources\LabelResource;
use App\Services\LabelService;
use Illuminate\Http\Response;

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
     * @param LabelListRequest $request
     * @return LabelCollectionResource
     */
    public function index(LabelListRequest $request)
    {
        $labels = $this->service->paginate($request->queryParamsObject());

        return new LabelCollectionResource($labels);
    }

    /**
     * @param LabelStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LabelStoreRequest $request)
    {
        $label = $this->service->create($request->all());
        return (new LabelResource($label))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param LabelShowRequest $request
     * @param integer $id
     * @return LabelResource
     */
    public function show(LabelShowRequest $request, int $id)
    {
        return new LabelResource($request->model());
    }

    /**
     * @param LabelUpdateRequest $request
     * @param integer            $id
     * @return LabelResource
     */
    public function update(LabelUpdateRequest $request, int $id)
    {
        $label = $this->service->update($request->all(), $id);
        return new LabelResource($label);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LabelDestroyRequest $request
     * @param  integer $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabelDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
