<?php

namespace App\Http\Controllers\API;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\DocumentPatchRequest;
use App\Http\Requests\Document\DocumentSetActualVersionRequest;
use App\Http\Requests\Document\DocumentStoreRequest;
use App\Http\Requests\Document\DocumentUpdateRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\DocumentResource;
use App\Services\Document\DocumentService;
use App\Services\Document\TransactionDocumentService;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

class DocumentController extends Controller
{
    public function index(DocumentService $documentService, FilterRequest $request)
    {
        $documents = $documentService->list($request->getFilter());

        return (DocumentResource::collection($documents))->response()->setStatusCode(200);
    }

    public function store(DocumentStoreRequest $request, TransactionDocumentService $service)
    {
        $document = $service->create($request->getEntity());

        return (new DocumentResource($document))->response()->setStatusCode(201);
    }

    public function show(DocumentService $documentService, int $id)
    {
        $document = $documentService->get($id);
        return (new DocumentResource($document))->response()->setStatusCode(200);
    }

    public function update(DocumentUpdateRequest $request, TransactionDocumentService $documentService, int $id)
    {
        $createNewVersion = $request->get('createNewVersion', true);
        $document = $documentService->update($id, $request->getEntity(), $request->getUpdatedFields(), $createNewVersion);

        return (new DocumentResource($document))->response()->setStatusCode(200);
    }

    public function destroy(DocumentService $documentService, int $id)
    {
        $documentService->delete($id);

        return response('', 204);
    }

    public function setActualVersion(DocumentSetActualVersionRequest $request, TransactionDocumentService $documentService, $id)
    {
        $document = $documentService->setActualVersion($id, $request->getVersionId());
        return (new DocumentResource($document))->response()->setStatusCode(200);
    }

    public function patchUpdate(DocumentPatchRequest $request, TransactionDocumentService $service, $id)
    {
        $document = $service->update($id, $request->getEntity(), $request->getUpdatedFields(), false);

        return (new DocumentResource($document))->response()->setStatusCode(200);
    }


//    public function massArchive(Request $request, IAtomCommandInvoker $invoker)
//    {
//        foreach ($ids = $request->get('ids') as $key => $id) {
//            $document = Document::find($id);
//            $authorizer = AuthorizerFactory::make('document', $document);
//            try {
//                $authorizer->authorize('document_archive');
//            } catch (Exception $e) {
//                unset($ids[$key]);
//            }
//        }
//
//        $documentsDeleteCommand = app()->makeWith(IDocumentsDeleteCommand::class, [
//            'ids' => $ids,
//            'substituteDocumentId' => $request->get('documentId')
//        ]);
//        $invoker->invoke($documentsDeleteCommand);
//        $documentsDeleted = $documentsDeleteCommand->getResult();
//
//        return new JsonResponse(['total' => $documentsDeleted]);
//    }
//
//    public function massDelete(Request $request, IAtomCommandInvoker $invoker)
//    {
//        foreach ($ids = $request->get('ids') as $key => $id) {
//            $document = Document::find($id);
//            $authorizer = AuthorizerFactory::make('document', $document);
//            try {
//                $authorizer->authorize('document_delete');
//            } catch (Exception $e) {
//                unset($ids[$key]);
//            }
//        }
//
//        $documentsDeleteCommand = app()->makeWith(IDocumentsDeleteCommand::class, [
//            'ids' => $ids,
//            'force' => true
//        ]);
//        $invoker->invoke($documentsDeleteCommand);
//        $documentsDeleted = $documentsDeleteCommand->getResult();
//
//        return new JsonResponse(['total' => $documentsDeleted]);
//    }
//
//    public function exportDocument($id, Request $request, Container $container)
//    {
//        /** @var ADocumentExportService $documentVersionExportService */
//        $documentVersionExportService = $container->makeWith(ADocumentExportService::class, [
//            'container' => $container,
//            'documentId' => $id,
//            'params' => $request->get('params'),
//            'publish' => $request->has('publish'),
//            'fileName' => $request->get('fileName'),
//            'format' => $request->get('format'),
//        ]);
//        $documentVersionExportService->execute();
//
//        return new JsonResponse(['fileUrl' => $documentVersionExportService->getFileUrl(), 'publish' => $documentVersionExportService->isPublish()]);
//    }
//
//    public function getList(Request $request)
//    {
//        $query = Document::where('name', 'LIKE', '%' . $request->query->get('query') . '%');
//
//        if ($request->has('exceptIds')) {
//            $query->whereNotIn('id', explode(',', $request->get('exceptIds')));
//        }
//
//        if ($request->has('withoutArchived') && !$request->get('withoutArchived')) {
//            $query->trashed();
//        }
//
//        return json_encode($query->get()->toArray());
//    }
//
//    public function getDocumentAttributeValues(Request $request)
//    {
//        $values = DB::table("attributes")->select(["attribute_values.value"])
//            ->distinct()
//            ->join("attribute_values", function ($join) {
//                $join->on('attribute_values.attribute_id', '=', 'attributes.id');
//            })
//            ->join("document_versions", function ($join) {
//                $join->on('attribute_values.document_version_id', '=', 'document_versions.id');
//            })
//            ->where("document_versions.is_actual", 1)
//            ->where('attributes.id', $request->get('attributeId'))
//            ->where("attributes.type_id", 1)
//            ->where("attribute_values.value", "!=", "")
//            ->where("attribute_values.value", "LIKE", $request->get('query').'%')
//            ->get()->pluck('value');
//
//        return json_encode($values);
//    }
}
