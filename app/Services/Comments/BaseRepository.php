<?php

namespace App\Services\Comments;

abstract class BaseRepository implements IRepository
{
    abstract public function getInstance();

    public function all()
    {
        return $this->getInstance()->all();
    }

    public function find(int $id)
    {
        return $this->getInstance()->findOrFail($id);
    }

    public function create(array $data)
    {
        $model = $this->getInstance()->create($data);
        return $this->getInstance()->findOrFail($model->id);
    }

    public function update(array $data, int $id)
    {
        $this->getInstance()->where('id', $id)->update($data);
        return $this->getInstance()->findOrFail($id);
    }

    public function delete(int $id)
    {
        return $this->getInstance()->where('id', $id)->delete();
    }
}
