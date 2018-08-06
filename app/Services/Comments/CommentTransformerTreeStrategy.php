<?php

namespace App\Services\Comments;

use Illuminate\Database\Eloquent\Collection;

class CommentTransformerTreeStrategy implements ITransformerStrategy
{
    public function make(Collection $comments, int $pageNumber)
    {
        $transformedComments = new CommentsCollection([], $pageNumber);

        foreach ($comments as $comment)
        {
            if ($comment->parent_id == null)
            {
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

                $transformedComments->push($leafComment);
            }
        }

        return $transformedComments;
    }

    function rawToStructuredDataTree($data) {
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
}
