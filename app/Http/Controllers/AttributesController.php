<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\AttributeCreateRequest;
use App\Http\Requests\AttributeUpdateRequest;
use App\Http\Resources\AttributeCollectionResource;
use App\Http\Resources\AttributeResource;
use App\Services\AttributeService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $attributes = $this->service->paginate();
        return AttributeResource::collection($attributes);
    }

    public function store($templateId, AttributeCreateRequest $request)
    {
        $attribute = $this->service->create($templateId, $request->all());
        return new AttributeResource($attribute);
    }

    /**
     * @param $id
     * @return AttributeResource
     */
    public function show($id)
    {
        $attribute = $this->service->find($id);
        return new AttributeResource($attribute);
    }

    /**
     * @param AttributeUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AttributeUpdateRequest $request, $id)
    {
        $attribute = $this->service->update($request->all(), $id);
        return new AttributeResource($attribute);
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
