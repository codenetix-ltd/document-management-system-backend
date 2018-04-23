<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Resources\TemplateResource;
use App\Http\Controllers\Controller;
use App\Services\Template\TemplateService;

class TemplateController extends Controller
{
    public function index(TemplateService $templateListService)
    {
        $users = $templateListService->list();

        return (TemplateResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(TemplateStoreRequest $request, TemplateService $templateCreateService)
    {
        $template = $templateCreateService->create($request->getEntity());

        return (new TemplateResource($template))->response()->setStatusCode(201);
    }

    public function show(TemplateService $templateGetService, int $id)
    {
        $template = $templateGetService->get($id);

        return (new TemplateResource($template))->response()->setStatusCode(200);
    }

    public function update(TemplateUpdateRequest $request, TemplateService $templateUpdateService, int $id)
    {
        $template = $templateUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());

        return (new TemplateResource($template))->response()->setStatusCode(200);
    }

    //TODO - добавить проверку, есть ли в наличии документы с таким шаблоном
    public function destroy(TemplateService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
