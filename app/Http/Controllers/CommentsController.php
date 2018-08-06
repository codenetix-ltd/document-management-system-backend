<?php

namespace App\Http\Controllers;

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
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResource
     */
    public function store(Request $request)
    {
//        $comment = Comment::create($request->all(), 201);
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
//        $comment = Comment::findOrFail($id);
        $comment = $this->service->find($id);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return CommentResource
     */
    public function update(Request $request, int $id)
    {
//        $comment = Comment::find($id);
//        $comment->fill($request->all());
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
//        $comment = Comment::find($id);
//        if ($comment)
//        {
//            $comment->delete();
//        }
        $comment = $this->service->find($id);
        if ($comment)
        {
            $this->service->delete($id);
        }
        return response()->json([], 204); // Response::HTTP_NO_CONTENT == 204
    }

    /**
     * Display comments in defined page and rootComment.
     *
     * @param int $pageNumber
     * @param int $rootCommentId
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByPageNumberAndRootCommentId(int $rootCommentId, int $pageNumber)
    {
        $comments = $this->service->getCommentsByRootCommentId($rootCommentId, $pageNumber);
        return response()->json($comments);
    }


    /**
     * Display comments in defined page and document.
     *
     * @param int $pageNumber
     * @param int $documentId
     * @return \Illuminate\Http\Response
     */
    public function getCommentsByPageNumberAndDocumentId(int $documentId, int $pageNumber)
    {
        $comments = $this->service->getCommentsTreeByDocumentId($documentId, $pageNumber);
        return response()->json($comments);
    }
}
