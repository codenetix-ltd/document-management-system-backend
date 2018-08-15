<?php

namespace App\Services\Comments;

abstract class BaseRepository implements IRepository
{
    /**
     * @return mixed
     */
    abstract public function getInstance();

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->getInstance()->all();
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->getInstance()->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $model = $this->getInstance()->create($data);
        return $this->getInstance()->findOrFail($model->id);
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $this->getInstance()->where('id', $id)->update($data);
        return $this->getInstance()->findOrFail($id);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->getInstance()->where('id', $id)->delete();
    }
}
