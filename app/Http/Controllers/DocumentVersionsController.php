<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentVersion\DocumentVersionDestroyRequest;
use App\Http\Requests\DocumentVersion\DocumentVersionShowRequest;
use App\Http\Requests\DocumentVersion\DocumentVersionStoreRequest;
use App\Http\Requests\DocumentVersion\DocumentVersionUpdateRequest;
use App\Http\Resources\DocumentVersionResource;
use App\Services\DocumentVersionService;
use Illuminate\Http\Response;

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
     * Store a newly created resource in storage.
     *
     * @param  DocumentVersionStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DocumentVersionStoreRequest $request)
    {
        $documentVersion = $this->service->create($request->all(), false);
        return (new DocumentVersionResource($documentVersion))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param DocumentVersionShowRequest $request
     * @param integer $documentVersionId
     * @return DocumentVersionResource
     */
    public function show(DocumentVersionShowRequest $request, int $documentVersionId)
    {
        return new DocumentVersionResource($request->model());
    }

    /**
     * @param integer                      $documentVersionId
     * @param DocumentVersionUpdateRequest $request
     * @return DocumentVersionResource
     */
    public function update(DocumentVersionUpdateRequest $request, int $documentVersionId)
    {
        $documentVersion = $this->service->update($request->all(), $documentVersionId);
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * @param DocumentVersionDestroyRequest $request
     * @param int $documentVersionId
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FailedDeleteActualDocumentVersion
     */
    public function destroy(DocumentVersionDestroyRequest $request, int $documentVersionId)
    {
        $this->service->delete($documentVersionId);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
