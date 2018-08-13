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
        return $this->getInstance()->create($data);
    }

    public function update(array $data, int $id)
    {
        $model = $this->getInstance()->findOrFail($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->getInstance()->find($id);
        $deleted = $model->delete();
        return $deleted;
    }


}
