<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

class CommentTransformerTreeStrategy implements ITransformerStrategy
{
    public function make(Collection $comments)
    {
        $transformedComments = new CommentsCollection([]);
        foreach ($comments as $comment)
        {
            if (isset($comment->parent_id))
            {
                $rootComment = new RootComment();
                $rootComment->setId($comment->id);
                $rootComment->setUserId($comment->user_id);
                $rootComment->setEntityId($comment->entity_id);
                $rootComment->setEntityType($comment->entity_type);
                $rootComment->setParentId($comment->parent_id);
                $rootComment->setMessage($comment->body);
                $rootComment->setCreatedAt($comment->created_at);
                $rootComment->setUpdatedAt($comment->updated_at);
                $rootComment->setDeletedAt($comment->deleted_at);
                

            } else {
                $leafComment = new LeafComment();
                $leafComment->setId($comment->id);
                $leafComment->setUserId($comment->user_id);
                $leafComment->setEntityId($comment->entity_id);
                $leafComment->setEntityType($comment->entity_type);
                $leafComment->setParentId($comment->parent_id);
                $leafComment->setMessage($comment->body);
                $leafComment->setCreatedAt($comment->created_at);
                $leafComment->setUpdatedAt($comment->updated_at);
                $leafComment->setDeletedAt($comment->deleted_at);
            }


        }
        return $transformedComments;
    }

    public function rawToStructuredDataTree($data) {
        $structured_array = array();
        foreach ($data as $cid => $node) {
            $data[$cid]['children'] = array();
            if ($node['parent_id'] == $cid || $node['parent_id'] == 0) {
                $structured_array[$cid] = & $data[$cid];
            } else {
                $data[$node['parent_id']]['children'][$cid] = & $data[$cid];
            }
        }
        return $structured_array;
    }

//        foreach ($comments as $comment)
//        {
//            if ($comment->parent_id == null)
//            {
//                $leafComment = new LeafComment();
//                $leafComment->setId($comment->id);
//                $leafComment->setUserId($comment->user_id);
//                $leafComment->setEntityId($comment->entity_id);
//                $leafComment->setEntityType($comment->entity_type);
//                $leafComment->setParentId($comment->parent_id);
//                $leafComment->setMessage($comment->body);
//                $leafComment->setCreatedAt($comment->created_at);
//                $leafComment->setUpdatedAt($comment->updated_at);
//                $leafComment->setDeletedAt($comment->deleted_at);
//
//                $transformedComments->push($leafComment);
//            }
//
//            $rootComment = new RootComment();
//            $rootComment->setId($comment->id);
//            $rootComment->setUserId($comment->user_id);
//            $rootComment->setEntityId($comment->entity_id);
//            $rootComment->setEntityType($comment->entity_type);
//            $rootComment->setParentId($comment->parent_id);
//            $rootComment->setMessage($comment->body);
//            $rootComment->setCreatedAt($comment->created_at);
//            $rootComment->setUpdatedAt($comment->updated_at);
//            $rootComment->setDeletedAt($comment->deleted_at);
//
//            $rootCommentId=$rootComment->getId();
//            if ($comment->id = $rootCommentId)
//            {
//
//            }
//
//
//
//        }
}
