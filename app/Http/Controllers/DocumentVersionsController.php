<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentVersionCreateRequest;
use App\Http\Requests\DocumentVersionUpdateRequest;
use App\Http\Resources\DocumentVersionCollectionResource;
use App\Http\Resources\DocumentVersionResource;
use App\Services\DocumentService;
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
     * @param $documentId
     * @return DocumentVersionCollectionResource
     */
    public function index($documentId)
    {
        $documentVersions = $this->service->list($documentId);
        return new DocumentVersionCollectionResource($documentVersions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $documentId
     * @param  DocumentVersionCreateRequest $request
     *
     * @param DocumentService $documentService
     * @return DocumentVersionResource
     */
    public function store($documentId, DocumentVersionCreateRequest $request, DocumentService $documentService)
    {
        $document = $documentService->find($documentId);
        $version = (int)$document->documentActualVersion->versionName + 1;

        $documentVersion = $this->service->create($request->all(), $document->id, $version, false);

        return new DocumentVersionResource($documentVersion);
    }

    /**
     * Display the specified resource.
     *
     * @param $documentId
     * @param $documentVersionId
     * @return DocumentVersionResource
     */
    public function show($documentId, $documentVersionId)
    {
        $documentVersion = $this->service->find($documentVersionId);
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * @param $documentId
     * @param $documentVersionId
     * @param DocumentVersionUpdateRequest $request
     * @return DocumentVersionResource
     */
    public function update($documentId, $documentVersionId, DocumentVersionUpdateRequest $request)
    {
        $documentVersion = $this->service->update($request->all(), $documentVersionId);
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $documentId
     * @param $documentVersionId
     * @return \Illuminate\Http\Response
     */
    public function destroy($documentId, $documentVersionId)
    {
        $this->service->delete($documentVersionId);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
