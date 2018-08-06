<?php

namespace App\Services\Comments;

abstract class BaseRepository implements IRepository
{
    abstract function getInstance();

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
        return $this->getInstance()->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->getInstance()->delete($id);
    }
}
