<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentPatchUpdateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentCollectionResource;
use App\Http\Resources\DocumentResource;
use App\Services\DocumentService;
use Illuminate\Http\Response;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
        $document = $this->service->create($request->all());
        return new DocumentResource($document);
    }

    /**
     * @param $id
     * @return DocumentResource
     */
    public function show($id)
    {
        $document = $this->service->find($id);
        return new DocumentResource($document);
    }

    /**
     * @param DocumentUpdateRequest $request
     * @param $id
     * @return DocumentResource
     */
    public function update(DocumentUpdateRequest $request, $id)
    {
        $document = $this->service->updateVersion($request->all(), $id);
        return new DocumentResource($document);
    }

    /**
     * @param DocumentPatchUpdateRequest $request
     * @param $id
     * @return DocumentResource
     */
    public function patchUpdate(DocumentPatchUpdateRequest $request, $id)
    {
        $document = $this->service->update($request->all(), $id);
        return new DocumentResource($document);
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
