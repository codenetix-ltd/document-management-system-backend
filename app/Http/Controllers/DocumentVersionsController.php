<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentVersionCreateRequest;
use App\Http\Requests\DocumentVersionUpdateRequest;
use App\Http\Resources\DocumentVersionCollectionResource;
use App\Http\Resources\DocumentVersionResource;
use App\Services\DocumentService;
use App\Services\DocumentVersionService;
use App\System\AuthBuilders\AuthorizerFactory;
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
     * Display a listing of the resource.
     *
     * @param integer $documentId
     * @return DocumentVersionCollectionResource
     */
    public function index(int $documentId)
    {
        $documentVersions = $this->service->list($documentId);
        return new DocumentVersionCollectionResource($documentVersions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param integer                      $documentId
     * @param  DocumentVersionCreateRequest $request
     *
     * @param DocumentService              $documentService
     * @return DocumentVersionResource
     */
    public function store(int $documentId, DocumentVersionCreateRequest $request, DocumentService $documentService)
    {
        $document = $documentService->find($documentId);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_update');

        $version = (int)$document->documentActualVersion->versionName + 1;

        $documentVersion = $this->service->create($request->all(), $document->id, $version, false);

        return new DocumentVersionResource($documentVersion);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $documentId
     * @param integer $documentVersionId
     * @return DocumentVersionResource
     */
    public function show(int $documentId, int $documentVersionId)
    {
        $documentVersion = $this->service->find($documentVersionId);

        $authorizer = AuthorizerFactory::make('document', $documentVersion->document);
        $authorizer->authorize('document_view');

        return new DocumentVersionResource($documentVersion);
    }

    /**
     * @param integer                      $documentId
     * @param integer                      $documentVersionId
     * @param DocumentVersionUpdateRequest $request
     * @return DocumentVersionResource
     */
    public function update(int $documentId, int $documentVersionId, DocumentVersionUpdateRequest $request)
    {
        $documentVersion = $this->service->find($documentVersionId);

        $authorizer = AuthorizerFactory::make('document', $documentVersion->document);
        $authorizer->authorize('document_update');

        $documentVersion = $this->service->update($request->all(), $documentVersionId);
        return new DocumentVersionResource($documentVersion);
    }

    /**
     * @param integer $documentId
     * @param integer $documentVersionId
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FailedDeleteActualDocumentVersion
     */
    public function destroy(int $documentId, int $documentVersionId)
    {
        $documentVersion = $this->service->findModel($documentVersionId);

        if ($documentVersion) {
            $authorizer = AuthorizerFactory::make('document', $documentVersion->document);
            $authorizer->authorize('document_update');
        }

        $this->service->delete($documentVersionId);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
