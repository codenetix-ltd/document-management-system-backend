<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentVersionResource;
use App\Services\Document\DocumentVersionService;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionController extends Controller
{
    public function index(DocumentVersionService $service, $documentId)
    {
        //TODO service returns common collection, should we use pagination?
        $documentVersions = $service->list($documentId);

        return (DocumentVersionResource::collection($documentVersions))->response()->setStatusCode(200);
    }

    public function destroy(DocumentVersionService $service, $id, $versionId)
    {
        $service->delete($versionId);

        return response('', 204);
    }

    public function show($id, $versionId, DocumentVersionService $service)
    {
        $dv = $service->get($versionId);

        return (new DocumentVersionResource($dv))->response()->setStatusCode(200);
    }
}
