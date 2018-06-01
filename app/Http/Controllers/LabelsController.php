<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\LabelUpdateRequest;
use App\Http\Resources\LabelCollectionResource;
use App\Http\Resources\LabelResource;
use App\Services\LabelService;
use App\System\AuthBuilders\AuthorizerFactory;
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
     * @return LabelCollectionResource
     */
    public function index()
    {
        $labels = $this->service->paginate();
        return new LabelCollectionResource($labels);
    }

    /**
     * @param LabelCreateRequest $request
     * @return LabelResource
     */
    public function store(LabelCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('label');
        $authorizer->authorize('label_create');

        $label = $this->service->create($request->all());
        return new LabelResource($label);
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
        $label = $this->service->findModel($id);

        if ($label) {
            $authorizer = AuthorizerFactory::make('label', $label);
            $authorizer->authorize('label_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
