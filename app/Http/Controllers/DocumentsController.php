<?php

namespace App\Http\Controllers;

use App\AttributeValue;
use App\Builders\ParameterBuilders\DocumentViewParameterCollectionBuilder;
use App\Builders\ParameterBuilders\DocumentViewVersionParameterCollectionBuilder;
use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\Document\IDocumentDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionGetCommand;
use App\Contracts\Commands\Factory\IFactoryListCommand;
use App\Contracts\Commands\Label\ILabelListCommand;
use App\Contracts\Commands\Tag\ITagListCommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Commands\User\IUserListCommand;
use App\DataTables\DocumentsDataTable;
use App\Document;
use App\DocumentVersion;
use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentUpdateEvent;
use App\Helpers\Builders\AuthorizerFactory;
use App\Label;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\AttributesGetService;
use App\Tag;
use App\Type;
use App\User;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FileFacade;

class DocumentsController extends Controller
{
    /**
     * @param DocumentsDataTable $dataTable
     * @param IAtomCommandInvoker $invoker
     * @param IFactoryListCommand $factoryListCommand
     * @param ITemplateListCommand $templateListCommand
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(DocumentsDataTable $dataTable, IAtomCommandInvoker $invoker, IFactoryListCommand $factoryListCommand, ITemplateListCommand $templateListCommand, ILabelListCommand $labelListCommand)
    {
        $invoker->invoke($factoryListCommand);
        $factories = $factoryListCommand->getResult();

        $invoker->invoke($templateListCommand);
        $templates = $templateListCommand->getResult();

        $invoker->invoke($labelListCommand);
        $labels = $labelListCommand->getResult();

        return $dataTable->render('pages.documents.index', compact('factories', 'templates', 'labels'));
    }

    public function delete($id, Container $container)
    {
        $documentGetService = app()->makeWith(ADocumentGetService::class, [
            'container' => $container,
            'documentId' => $id
        ]);
        $documentGetService->execute();

        $authorizer = AuthorizerFactory::make('document', $documentGetService->getDocument()->getBaseModel());
        $authorizer->authorize('document_delete');

        $documentDeleteCommand = app()->makeWith(IDocumentDeleteCommand::class, [
            'container' => $container,
            'id' => $id,
            'force' => true
        ]);
        $documentDeleteCommand->execute();

        return back()->with('success', 'Document "' . $documentGetService->getDocument()->getName() . '" has been removed with success!');
    }

    /**
     * @param $documentVersionId
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDocumentVersion($documentVersionId, IAtomCommandInvoker $invoker)
    {
        $documentVersionGetCommand = app()->makeWith(IDocumentVersionGetCommand::class, [
            'id' => $documentVersionId
        ]);
        $invoker->invoke($documentVersionGetCommand);
        $documentVersion = $documentVersionGetCommand->getResult();

        $authorizer = AuthorizerFactory::make('document', $documentVersion->document);
        $authorizer->authorize('document_delete');

        if ($documentVersion->is_actual) {
            return redirect(route('documents.edit', ['id' => $documentVersion->document_id]) . '#versions')->with('error', 'Unable to remove actual version "' . $documentVersion->version_name . '"!');
        }

        $documentVersionDeleteCommand = app()->makeWith(IDocumentVersionDeleteCommand::class, [
            'id' => $documentVersionId
        ]);
        $invoker->invoke($documentVersionDeleteCommand);

        return redirect(route('documents.edit', ['id' => $documentVersion->document_id]) . '#versions')->with('success', 'Document version "' . $documentVersion->version_name . '" has been deleted!');
    }


    public function create(Container $container, IAtomCommandInvoker $atomCommandInvoker)
    {
        $authorizer = AuthorizerFactory::make('document');
        $authorizer->authorize('document_create');
        $availableFactoriesIds = $authorizer->getAvailableFactoriesIds();

        $factoryListCommand = app()->makeWith(IFactoryListCommand::class, [
            'columns' => ['id', 'name'],
            'ids' => $availableFactoriesIds,
            'container' => $container,
            'strict' => true
        ]);
        $atomCommandInvoker->invoke($factoryListCommand);
        $factories = $factoryListCommand->getResult();

        $availableTemplatesIds = $authorizer->getAvailableTemplatesIds();
        $templateListCommand = app()->makeWith(ITemplateListCommand::class, [
            'columns' => ['id', 'name'],
            'ids' => $availableTemplatesIds,
            'container' => $container,
            'strict' => true
        ]);
        $atomCommandInvoker->invoke($templateListCommand);
        $templates = $templateListCommand->getResult();

        $tagListCommand = app()->makeWith(ITagListCommand::class, [
            'columns' => ['id', 'name']
        ]);
        $atomCommandInvoker->invoke($tagListCommand);
        $tags = $tagListCommand->getResult();

        $labelListCommand = app()->makeWith(ILabelListCommand::class, [
            'columns' => ['id', 'name']
        ]);
        $atomCommandInvoker->invoke($labelListCommand);
        $labels = $labelListCommand->getResult();

        $userListCommand = app()->makeWith(IUserListCommand::class, [
            'columns' => ['id', 'full_name']
        ]);
        $atomCommandInvoker->invoke($userListCommand);
        $users = $userListCommand->getResult();

        $templateId = old('template_id');
        if ($templateId) {
            $attributesGetService = new AttributesGetService($container, $templateId);
            $attributesGetService->execute();
            $attributes = $attributesGetService->getAttributes();
        }

        return view('pages.documents.add_edit', compact('factories', 'templates', 'tags', 'users', 'attributes', 'labels'));
    }

    /**
     * @param Request $request
     * @param Container $container
     * @return View
     */
    public function compare(Request $request, Container $container) : View
    {
        $documentIds = explode(',', $request->query('documentIds'));
        $templateId = $request->query('templateId', null);
        $onlyDifferences = boolval($request->query('onlyDifferences', false));

        $service = $container->makeWith(ADocumentCompareService::class, compact('container', 'documentIds', 'onlyDifferences', 'templateId'));
        $service->execute();

        return view('pages.extra.compare', [
            'documentCompareStructure' => $service->getDocumentCompareStructure(),
            'documentGroups' => $service->getDocumentGroups(),
            'onlyDifferences' => $onlyDifferences,
            'originalDocumentIdsParam' => $request->query('documentIds', ''),
            'originalTemplateIdParam' => $request->query('templateId', null)
        ]);
    }

    public function listFiles($documentId)
    {
        $document = Document::findOrFail($documentId);
        $files = $document->documentActualVersion->files;
        $result = [];
        foreach ($files as $file) {
            $result[] = [
                'id' => $file->id,
                'type' => FileFacade::mimeType(public_path('storage/' . $file->path)),
                'url' => asset('storage/' . $file->path),
                'name' => $file->original_name,
                'size' => FileFacade::size(public_path('storage/' . $file->path)),
                'deleteUrl' => route('document_attachments.delete', [$file->id]),
                'deleteType' => 'DELETE'
            ];
        }

        return response()->json(['files' => $result]);
    }

    public function getDocumentVersion($documentVersionId, Container $container, Request $request)
    {
        $documentVersion = DocumentVersion::findOrFail($documentVersionId);
        $documentId = $documentVersion->document->id;

        $authorizer = AuthorizerFactory::make('document', $documentVersion->document);
        $authorizer->authorize('document_view');

        $parameterBuilder = new DocumentViewVersionParameterCollectionBuilder();
        $service = $container->makeWith(ADocumentViewService::class, compact('container', 'documentId', 'documentVersionId', 'parameterBuilder'));
        $service->execute();

        $exportMode = (bool)$request->get('exportMode', false);

        return view('pages.documents.version', [
            'document' => $service->getDocument(),
            'types' => Type::all(),
            'exportMode' => $exportMode
        ]);
    }

    /**
     * @param $documentId
     * @param Container $container
     * @return View
     */
    public function view($documentId, Container $container)
    {
        $parameterBuilder = new DocumentViewParameterCollectionBuilder();
        $service = $container->makeWith(ADocumentViewService::class, compact('container', 'documentId', null, 'parameterBuilder'));
        $service->execute();

        $authorizer = AuthorizerFactory::make('document', $service->getDocument()->getBaseModel());
        $authorizer->authorize('document_view');

        return view('pages.documents.view', compact('types', 'document'),
            [
                'document' => $service->getDocument(),
                'types' => Type::all(),
                'viewMode' => true
            ]
        );
    }

    /**
     * @param Container $container
     * @param Request $request
     * @return View
     */
    public function listAttributes(Container $container, Request $request)
    {
        $templateId = $request->query('template_id');
        $documentVersionId = $request->query('document_version_id');

        $attributesGetService = new AttributesGetService($container, $templateId, $documentVersionId);
        $attributesGetService->execute();

        $types = Type::all();
        return view('partials.attributes', [
            'attributes' => $attributesGetService->getAttributes(),
            'types' => $types
        ]);
    }

    /**
     * @param Container $container
     * @param $documentId
     * @return View
     */
    public function edit(Container $container, $documentId, IAtomCommandInvoker $atomCommandInvoker)
    {
        //TODO: dirty deals.
        $document = Document::findOrFail($documentId);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_update');

        $availableFactoriesIds = $authorizer->getAvailableFactoriesIds();
        $factoryListCommand = app()->makeWith(IFactoryListCommand::class, [
            'columns' => ['id', 'name'],
            'ids' => $availableFactoriesIds,
            'container' => $container,
            'strict' => true
        ]);
        $atomCommandInvoker->invoke($factoryListCommand);
        $factories = $factoryListCommand->getResult();

        $availableTemplatesIds = $authorizer->getAvailableTemplatesIds();
        $templateListCommand = app()->makeWith(ITemplateListCommand::class, [
            'columns' => ['id', 'name'],
            'ids' => $availableTemplatesIds,
            'container' => $container,
            'strict' => true
        ]);
        $atomCommandInvoker->invoke($templateListCommand);
        $templates = $templateListCommand->getResult();

        $tags = Tag::all(['id', 'name']);
        $labels = Label::all(['id', 'name']);
        $users = User::all(['id', 'full_name'])->map(function ($item) {
            return ['id' => $item['id'], 'name' => $item['full_name']];
        });

        $service = $container->makeWith(ADocumentViewService::class, compact('container', 'documentId'));
        $service->execute();

        $document = $service->getDocument();
        $model = $document->getBaseModel();

        $attributes = $document->getAttributes();
        return view('pages.documents.add_edit', compact('factories', 'templates', 'tags', 'users', 'document', 'labels', 'attributes', 'model'));
    }


    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|unique:documents,name,' . $id . '|max:255',
            'comment' => 'max:1024',
            'factory_id.*' => 'required|exists:factories,id',
            'labels.*' => 'sometimes|exists:labels,id|nullable',
            'template_id' => 'required|exists:templates,id',
            'owner_id' => 'sometimes|exists:users,id|nullable',
            'files' => 'required|json',
            'attribute.*' => '',
            'increase_version' => 'in:0,1'
        ]);

        $document = Document::findOrFail($id);

        $authorizer = AuthorizerFactory::make('document', $document);
        $authorizer->authorize('document_update');

        $document = DB::transaction(function () use ($id, $request) {
            $document = Document::find($id);

            $files = json_decode($request->input('files', '[]'));
            $attributes = $request->input('attribute', []);
            $comment = $request->input('comment');
            $factories = $request->input('factory_id', []);
            $labels = $request->input('labels', []);

            $oldActualVersion = $document->documentActualVersion;

            if (!$request->has('increase_version')) {
                $oldActualVersion->update(array_merge($request->all()));
                $documentVersion = $oldActualVersion;
            } else {
                $oldActualVersion->update(['is_actual' => 0]);
                $oldActualVersion->version_name++;
                $documentVersion = DocumentVersion::create([
                    'version_name' => $oldActualVersion->version_name,
                    'is_actual' => 1,
                    'document_id' => $document->id,
                    'comment' => $comment
                ]);
            }

            DB::table('document_version_files')->whereDocumentVersionId($documentVersion->id)->delete();
            foreach ($files as $fileId) {
                DB::table('document_version_files')->insert(['file_id' => $fileId, 'document_version_id' => $documentVersion->id]);
            }

            $data = $request->all();

            $document->update($data);
            event(new DocumentUpdateEvent(Auth::user(), $document));
            $document->documentActualVersion = $documentVersion;

            DB::table('document_factories')->whereDocumentId($document->id)->delete();
            foreach ($factories as $factoryId) {
                DB::table('document_factories')->insert(['factory_id' => $factoryId, 'document_id' => $document->id]);
            }

            DB::table('document_label')->whereDocumentId($document->id)->delete();
            foreach ($labels as $labelId) {
                DB::table('document_label')->insert(['label_id' => $labelId, 'document_id' => $document->id]);
            }

            foreach ($attributes as $id => $attribute) {
                $currentAttribute = AttributeValue::whereAttributeId($id)->whereDocumentVersionId($documentVersion->id)->first();

                if (is_null($attribute)) {
                    continue;
                }

                if ($currentAttribute) {
                    $currentAttribute->update([
                        'document_version_id' => $documentVersion->id,
                        'value' => is_array($attribute) ? json_encode($attribute) : $attribute
                    ]);
                } else {
                    AttributeValue::create([
                        'attribute_id' => $id,
                        'document_version_id' => $documentVersion->id,
                        'value' => is_array($attribute) ? json_encode($attribute) : $attribute
                    ]);
                }

            }

            return $document;
        });

        return redirect()->route('documents.edit', ['id' => $document->id])->with('success', 'Document version #' . $document->documentActualVersion->version_name . ' has been updated!');
    }

    public function store(Request $request)
    {
        $authorizer = AuthorizerFactory::make('document');
        $authorizer->authorize('document_create');

        $this->validate($request, [
            'name' => 'bail|required|unique:documents|max:255',
            'comment' => 'max:1024',
            'factory_id.*' => 'required|exists:factories,id',
            'labels.*' => 'sometimes|exists:labels,id|nullable',
            'template_id' => 'required|exists:templates,id',
            'owner_id' => 'sometimes|exists:users,id|nullable',
            'files' => 'required|json',
            'attribute.*' => ''
        ]);

        $document = DB::transaction(function () use ($request) {
            $attributes = $request->input('attribute', []);
            $factories = $request->input('factory_id', []);
            $labels = $request->input('labels', []);
            $files = json_decode($request->input('files', '[]'));

            $comment = $request->input('comment');

            $data = $request->all();
            if (empty($data['owner_id'])) {
                $data['owner_id'] = Auth::user()->id;
            }
            $document = Document::create($data);
            event(new DocumentCreateEvent(Auth::user(), $document));

            $documentVersion = DocumentVersion::create([
                'version_name' => 1,
                'is_actual' => 1,
                'document_id' => $document->id,
                'comment' => $comment
            ]);

            foreach ($files as $fileId) {
                DB::table('document_version_files')->insert(['file_id' => $fileId, 'document_version_id' => $documentVersion->id]);
            }

            DB::table('document_factories')->whereDocumentId($document->id)->delete();
            foreach ($factories as $factoryId) {
                DB::table('document_factories')->insert(['factory_id' => $factoryId, 'document_id' => $document->id]);
            }

            DB::table('document_label')->whereDocumentId($document->id)->delete();
            foreach ($labels as $labelId) {
                DB::table('document_label')->insert(['label_id' => $labelId, 'document_id' => $document->id]);
            }

            foreach ($attributes as $id => $attribute) {
                if (is_null($attribute)) {
                    continue;
                }

                AttributeValue::create([
                    'attribute_id' => $id,
                    'document_version_id' => $documentVersion->id,
                    'value' => is_array($attribute) ? json_encode($attribute) : $attribute
                ]);
            }

            return $document;
        });

        return redirect()->route('documents.edit', ['id' => $document->id])->with('success', 'Document "' . $document->name . '" has been created!');
    }
}
