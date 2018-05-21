<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\DocumentVersionCreateRequest;
use App\Http\Requests\DocumentVersionUpdateRequest;
use App\Http\Resources\DocumentVersionCollectionResource;
use App\Http\Resources\DocumentVersionResource;
use App\Services\DocumentVersionService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class DocumentVersionsController extends Controller
{
    /**
     * @var DocumentVersionService
     */
    protected $service;

    /**
     * DocumentVersionsController constructor.
     * @param DocumentVersionService $service
     */
    public function __construct(DocumentVersionService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentVersions = $this->service->list();
        return new DocumentVersionCollectionResource($documentVersions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DocumentVersionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentVersionCreateRequest $request)
    {
        $documentVersion = $this->service->create($request->all());
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documentVersion = $this->service->find($id);
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * @param DocumentVersionUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DocumentVersionUpdateRequest $request, $id)
    {
        $documentVersion = $this->service->update($request->all(), $id);
        return new DocumentVersionResource($documentVersion);
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
