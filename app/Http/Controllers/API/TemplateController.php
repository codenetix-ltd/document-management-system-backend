<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\Template\ITemplateCreateService;
use App\Contracts\Services\Template\ITemplateDeleteService;
use App\Contracts\Services\Template\ITemplateGetService;
use App\Contracts\Services\Template\ITemplateListService;
use App\Contracts\Services\Template\ITemplateUpdateService;
use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Resources\TemplateResource;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function index(ITemplateListService $templateListService)
    {
        $users = $templateListService->list();

        return (TemplateResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(TemplateStoreRequest $request, ITemplateCreateService $templateCreateService)
    {
        $template = $templateCreateService->create($request->getEntity());

        return (new TemplateResource($template))->response()->setStatusCode(201);
    }

    public function show(ITemplateGetService $templateGetService, int $id)
    {
        $template = $templateGetService->get($id);

        return (new TemplateResource($template))->response()->setStatusCode(200);
    }

    public function update(TemplateUpdateRequest $request, ITemplateUpdateService $templateUpdateService, int $id)
    {
        $template = $templateUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());

        return (new TemplateResource($template))->response()->setStatusCode(200);
    }

    //TODO - добавить проверку, есть ли в наличии документы с таким шаблоном
    public function destroy(ITemplateDeleteService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
