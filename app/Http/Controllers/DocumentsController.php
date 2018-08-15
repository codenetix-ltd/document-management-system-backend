<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\DocumentBulkDestroyRequest;
use App\Http\Requests\Document\DocumentBulkPatchUpdateRequest;
use App\Http\Requests\Document\DocumentCreateRequest;
use App\Http\Requests\Document\DocumentDestroyRequest;
use App\Http\Requests\Document\DocumentListRequest;
use App\Http\Requests\Document\DocumentPatchUpdateRequest;
use App\Http\Requests\Document\DocumentShowRequest;
use App\Http\Requests\Document\DocumentUpdateRequest;
use App\Http\Requests\DocumentVersion\DocumentVersionListRequest;
use App\Http\Resources\DocumentCollectionResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentVersionCollectionResource;
use App\Services\DocumentService;
use App\Services\DocumentVersionService;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DocumentsController extends Controller
{
    /**
     * @var DocumentService
     */
    protected $service;

    /**
     * DocumentsController constructor.
     * @param DocumentService $service
     */
    public function __construct(DocumentService $service)
    {
        $this->service = $service;
    }

    /**
     * @param DocumentListRequest $request
     * @return DocumentCollectionResource
     */
    public function index(DocumentListRequest $request)
    {
        $documents = $this->service->paginate($request->queryParamsObject());
        return new DocumentCollectionResource($documents);
    }

    /**
     * Display a listing of the resource.
     *
     * @param DocumentVersionListRequest $request
     * @param DocumentVersionService     $documentVersionService
     * @param integer                    $documentId
     * @return DocumentVersionCollectionResource
     */
    public function versions(DocumentVersionListRequest $request, DocumentVersionService $documentVersionService, int $documentId)
    {
        $documentVersions = $documentVersionService->list($request->queryParamsObject(), $documentId);
        return new DocumentVersionCollectionResource($documentVersions);
    }

    /**
     * @param DocumentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DocumentCreateRequest $request)
    {
        $document = $this->service->create($request->all());
        return (new DocumentResource($document))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param DocumentShowRequest $request
     * @return DocumentResource
     */
    public function show(DocumentShowRequest $request)
    {
        return new DocumentResource($request->model());
    }

    /**
     * @param DocumentUpdateRequest $request
     * @param integer               $id
     * @return DocumentResource
     * @throws \App\Exceptions\FailedDeleteActualDocumentVersion
     */
    public function update(DocumentUpdateRequest $request, int $id)
    {
        $document = $this->service->updateVersion($request->all(), $id);
        return new DocumentResource($document);
    }

    /**
     * @param DocumentPatchUpdateRequest $request
     * @param integer                    $id
     * @return DocumentResource
     */
    public function patchUpdate(DocumentPatchUpdateRequest $request, int $id)
    {
        $document = $this->service->update($request->all(), $id);
        return new DocumentResource($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DocumentDestroyRequest $request
     * @param  integer                $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentDestroyRequest $request, int $id)
    {
        $this->service->delete($id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * @param DocumentBulkPatchUpdateRequest $request
     * @param DocumentService                $service
     *
     * @return DocumentCollectionResource
     */
    public function bulkPatchUpdate(DocumentBulkPatchUpdateRequest $request, DocumentService $service)
    {
        $ids = explode(',', $request->get('ids', ''));
        $data = $request->json()->all();

        $collection = new Collection();
        foreach ($ids as $currentKey => $currentId) {
            $collection->push($service->update($data[$currentKey], $currentId));
        }

        return new DocumentCollectionResource($collection);
    }

    /**
     * @param DocumentBulkDestroyRequest $request
     * @param DocumentService            $documentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(DocumentBulkDestroyRequest $request, DocumentService $documentService)
    {
        foreach ($request->getFilteredIds() as $id) {
            $documentService->delete($id);
        }

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
