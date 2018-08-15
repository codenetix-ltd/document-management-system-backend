<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentMakeTreeStructureRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentCollectionResource;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Response;

class CommentsController extends Controller
{
    /**
     * @var CommentService
     */
    protected $service;

    /**
     * AttributesController constructor.
     * @param CommentService $service
     */
    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CommentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentCreateRequest $request)
    {
        $comment = $this->service->create($request->all());
        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CommentResource
     */
    public function show(int $id)
    {
        $comment = $this->service->find($id);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentUpdateRequest $request
     * @param  int  $id
     * @return CommentResource
     */
    public function update(CommentUpdateRequest $request, int $id)
    {
        $comment = $this->service->update($request->all(), $id);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Display comments in defined page and rootComment.
     *
     * @param CommentMakeTreeStructureRequest $request
     * @param int $rootCommentId
     * @return CommentCollectionResource
     */
    public function getCommentsByRootCommentId(CommentMakeTreeStructureRequest $request, int $rootCommentId)
    {
        $comments = $this->service->getCommentsTreeByRootCommentId($rootCommentId, $request->query('pageNumber', 1));
        return new CommentCollectionResource($comments);
    }


    /**
     * Display comments in defined page and document.
     *
     * @param CommentMakeTreeStructureRequest $request
     * @param int $documentId
     * @return CommentCollectionResource
     */
    public function getCommentsByDocumentId(CommentMakeTreeStructureRequest $request, int $documentId)
    {
        $comments = $this->service->getCommentsTreeByDocumentId($documentId, $request->query('pageNumber', 1));
        return new CommentCollectionResource($comments);
    }
}
