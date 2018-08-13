<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Request;

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
     * @param  CommentCreateRequest  $request
     * @return CommentResource
     */
    public function store(CommentCreateRequest $request)
    {
        $comment = $this->service->create($request->all());
        return new CommentResource($comment);
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
        return response()->json([], 204); // Response::HTTP_NO_CONTENT == 204
    }

    /**
     * Display comments in defined page and rootComment.
     *
     * @param Request $request
     * @param int $rootCommentId
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByRootCommentId(Request $request, int $rootCommentId)
    {
        $comments = $this->service->getCommentsTreeByRootCommentId($rootCommentId, $request->query('pageNumber', 1));
        return response()->json($comments, 200);
    }


    /**
     * Display comments in defined page and document.
     *
     * @param Request $request
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByDocumentId(Request $request, int $documentId) // tree structure return
    {
        $comments = $this->service->getCommentsTreeByDocumentId($documentId, $request->query('pageNumber', 1));
        return response()->json($comments, 200);
    }
}
