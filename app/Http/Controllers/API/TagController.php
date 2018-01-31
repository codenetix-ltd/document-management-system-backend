<?php

namespace App\Http\Controllers\API;

use App\Contracts\Services\Tag\ITagCreateService;
use App\Contracts\Services\Tag\ITagDeleteService;
use App\Contracts\Services\Tag\ITagGetService;
use App\Contracts\Services\Tag\ITagListService;
use App\Contracts\Services\Tag\ITagUpdateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    public function index(ITagListService $templateListService)
    {
        $users = $templateListService->list();

        return (TagResource::collection($users))->response()->setStatusCode(200);
    }

    public function store(TagStoreRequest $request, ITagCreateService $tagCreateService)
    {
        $tag = $tagCreateService->create($request->getEntity());

        return (new TagResource($tag))->response()->setStatusCode(201);
    }

    public function show(ITagGetService $templateGetService, int $id)
    {
        $template = $templateGetService->get($id);

        return (new TagResource($template))->response()->setStatusCode(200);
    }

    public function update(TagUpdateRequest $request, ITagUpdateService $tagUpdateService, int $id)
    {
        $tag = $tagUpdateService->update($id, $request->getEntity(), $request->getUpdatedFields());

        return (new TagResource($tag))->response()->setStatusCode(200);
    }

    public function destroy(ITagDeleteService $userDeleteService, int $id)
    {
        $userDeleteService->delete($id);

        return response('', 204);
    }
}
