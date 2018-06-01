<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentBulkPatchUpdateRequest;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentPatchUpdateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentCollectionResource;
use App\Http\Resources\DocumentResource;
use App\Services\DocumentService;
use App\System\AuthBuilders\AuthorizerFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Validation\ValidationException;

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
     * @return DocumentCollectionResource
     */
    public function index()
    {
        $documents = $this->service->list();
        return new DocumentCollectionResource($documents);
    }

    /**
     * @param DocumentCreateRequest $request
     * @return DocumentResource
     */
    public function store(DocumentCreateRequest $request)
    {
        $authorizer = AuthorizerFactory::make('document');
        $authorizer->authorize('document_create');

        $document = $this->service->create($request->all());
        return new DocumentResource($document);
    }

    /**
     * @param integer $id
     * @return DocumentResource
     */
    public function show(int $id)
    {
        $document = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_view');

        return new DocumentResource($document);
    }

    /**
     * @param DocumentUpdateRequest $request
     * @param integer               $id
     * @return DocumentResource
     */
    public function update(DocumentUpdateRequest $request, int $id)
    {
        $document = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_update');

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
        $document = $this->service->find($id);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_update');

        $document = $this->service->update($request->all(), $id);
        return new DocumentResource($document);
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
        $document = $this->service->findModel($id);

        if ($document) {
            $authorizer = AuthorizerFactory::make('document', $document);
            $authorizer->authorize('document_delete');
        }

        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param DocumentBulkPatchUpdateRequest $request
     * @param DocumentService                $service
     *
     * @return DocumentCollectionResource
     * @throws ValidationException
     */
    public function bulkPatchUpdate(DocumentBulkPatchUpdateRequest $request, DocumentService $service)
    {
        $ids = explode(',', $request->get('ids', ''));

        $data = $request->json()->all();

        if (count($ids) != count($data)) {
            $request->failValidation();
        }

        $collection = new Collection();
        for ($i = 0; $i < count($ids); ++$i) {
            try {
                $document = $this->service->find($ids[$i]);
                $authorizer = AuthorizerFactory::make('document', $document);
                try {
                    $authorizer->authorize('document_update');
                } catch (Exception $e) {
                }

                $collection->push($service->update($data[$i], $ids[$i]));
            } catch (Exception $e) {
            }
        }

        return new DocumentCollectionResource($collection);
    }

    /**
     * @param Request         $request
     * @param DocumentService $documentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(Request $request, DocumentService $documentService)
    {
        $ids = explode(',', $request->get('ids', ''));

        foreach ($ids as $id) {
            $document = $this->service->findModel($id);
            if ($document) {
                $authorizer = AuthorizerFactory::make('document', $document);
                try {
                    $authorizer->authorize('document_delete');
                } catch (Exception $e) {
                }
            }

            $documentService->delete($id);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
