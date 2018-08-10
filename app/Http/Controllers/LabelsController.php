<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\LabelListRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Http\Resources\LabelCollectionResource;
use App\Http\Resources\LabelResource;
use App\Services\LabelService;
use App\System\AuthBuilders\AuthorizerFactory;
use Exception;
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
     * @param LabelCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LabelCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('label');
        $authorizer->authorize('label_create');

        $label = $this->service->create($request->all());
        return (new LabelResource($label))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param integer $id
     * @return LabelResource
     */
    public function show(int $id)
    {
        $label = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('label', $label);
        $authorizer->authorize('label_view');

        return new LabelResource($label);
    }

    /**
     * @param LabelUpdateRequest $request
     * @param integer            $id
     * @return LabelResource
     */
    public function update(LabelUpdateRequest $request, int $id)
    {
        $label = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('label', $label);
        $authorizer->authorize('label_update');

        $label = $this->service->update($request->all(), $id);
        return new LabelResource($label);
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
            $label = $this->service->find($id);
        } catch (Exception $e) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        if ($label) {
            $authorizer = AuthorizerFactory::make('label', $label);
            $authorizer->authorize('label_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
