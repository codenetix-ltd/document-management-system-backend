<?php

namespace App\Http\Controllers\API;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\Document\IDocumentsDeleteCommand;
use App\Document;
use App\Helpers\Builders\AuthorizerFactory;
use App\Packages\ImportExport\Services\ADocumentExportService;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

class DocumentController extends APIController
{
    public function massArchive(Request $request, IAtomCommandInvoker $invoker)
    {
        foreach ($ids = $request->get('ids') as $key => $id) {
            $document = Document::find($id);
            $authorizer = AuthorizerFactory::make('document', $document);
            try {
                $authorizer->authorize('document_archive');
            } catch (Exception $e) {
                unset($ids[$key]);
            }
        }

        $documentsDeleteCommand = app()->makeWith(IDocumentsDeleteCommand::class, [
            'ids' => $ids,
            'substituteDocumentId' => $request->get('documentId')
        ]);
        $invoker->invoke($documentsDeleteCommand);
        $documentsDeleted = $documentsDeleteCommand->getResult();

        return new JsonResponse(['total' => $documentsDeleted]);
    }

    public function massDelete(Request $request, IAtomCommandInvoker $invoker)
    {
        foreach ($ids = $request->get('ids') as $key => $id) {
            $document = Document::find($id);
            $authorizer = AuthorizerFactory::make('document', $document);
            try {
                $authorizer->authorize('document_delete');
            } catch (Exception $e) {
                unset($ids[$key]);
            }
        }

        $documentsDeleteCommand = app()->makeWith(IDocumentsDeleteCommand::class, [
            'ids' => $ids,
            'force' => true
        ]);
        $invoker->invoke($documentsDeleteCommand);
        $documentsDeleted = $documentsDeleteCommand->getResult();

        return new JsonResponse(['total' => $documentsDeleted]);
    }

    public function exportDocument($id, Request $request, Container $container)
    {
        /** @var ADocumentExportService $documentVersionExportService */
        $documentVersionExportService = $container->makeWith(ADocumentExportService::class, [
            'container' => $container,
            'documentId' => $id,
            'params' => $request->get('params'),
            'publish' => $request->has('publish'),
            'fileName' => $request->get('fileName'),
            'format' => $request->get('format'),
        ]);
        $documentVersionExportService->execute();

        return new JsonResponse(['fileUrl' => $documentVersionExportService->getFileUrl(), 'publish' => $documentVersionExportService->isPublish()]);
    }

    public function getList(Request $request)
    {
        $query = Document::where('name', 'LIKE', '%' . $request->query->get('query') . '%');

        if ($request->has('exceptIds')) {
            $query->whereNotIn('id', explode(',', $request->get('exceptIds')));
        }

        if ($request->has('withoutArchived') && !$request->get('withoutArchived')) {
            $query->trashed();
        }

        return json_encode($query->get()->toArray());
    }

    public function getDocumentAttributeValues(Request $request)
    {
        $values = DB::table("attributes")->select(["attribute_values.value"])
            ->distinct()
            ->join("attribute_values", function ($join) {
                $join->on('attribute_values.attribute_id', '=', 'attributes.id');
            })
            ->join("document_versions", function ($join) {
                $join->on('attribute_values.document_version_id', '=', 'document_versions.id');
            })
            ->where("document_versions.is_actual", 1)
            ->where('attributes.id', $request->get('attributeId'))
            ->where("attributes.type_id", 1)
            ->where("attribute_values.value", "!=", "")
            ->where("attribute_values.value", "LIKE", $request->get('query').'%')
            ->get()->pluck('value');

        return json_encode($values);
    }
}
