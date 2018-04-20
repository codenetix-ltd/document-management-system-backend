<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Http\Resources\TagResource;
use App\Services\Tag\TagService;

class TagController extends Controller
{
    public function index(TagService $templateListService)
    {
        $users = $templateListService->list();

        return (TagResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(TagStoreRequest $request, TagService $tagCreateService)
    {
        $tag = $tagCreateService->create($request->getEntity());

        return (new TagResource($tag))->response()->setStatusCode(201);
    }

    public function show(TagService $templateGetService, int $id)
    {
        $template = $templateGetService->get($id);

        return (new TagResource($template))->response()->setStatusCode(200);
    }

    public function update(TagUpdateRequest $request, TagService $tagUpdateService, int $id)
    {
        $tag = $tagUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());

        return (new TagResource($tag))->response()->setStatusCode(200);
    }

    public function destroy(TagService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
