<?php

namespace App\Repositories;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;
use App\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TagRepository implements ITagRepository
{
    public function create(ITag $tag): ITag
    {
        $tag->save();
        $tag = Tag::findOrFail($tag->getId());

        return $tag;
    }

    public function findOrFail(int $id): ITag
    {
        return Tag::findOrFail($id);
    }

    public function update(int $id, ITag $tagInput, array $updatedFields): ITag
    {
        $tag = Tag::findOrFail($id);

        foreach ($updatedFields as $fieldKey) {
            $tag->{dms_build_setter($fieldKey)}($tagInput->{dms_build_getter($fieldKey)}());
        }

        $tag->save();

        return $tag;
    }

    public function delete(int $id): ?bool
    {
        return Tag::where('id', $id)->delete();
    }

    public function list(): LengthAwarePaginatorContract
    {
        return Tag::paginate();
    }
}