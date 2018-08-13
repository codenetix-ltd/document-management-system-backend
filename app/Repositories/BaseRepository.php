<?php

namespace App\Repositories;

use App\Criteria\IQueryParamsObject;

abstract class BaseRepository
{

    /**
     * @return mixed
     */
    abstract protected function getInstance();

    /**
     * @return mixed
     */
    protected function getQuery(){
        return $this->getInstance()->newQuery();
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return mixed
     */
    public function paginateList(IQueryParamsObject $queryParamsObject)
    {
        return $this->getInstance()->paginate();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $entry = $this->getInstance()->create($data);

        return $this->getInstance()->find($entry->id);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($data, $id)
    {
        $this->getInstance()->findOrFail($id)->update($data);

        return $this->getInstance()->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id){
        return $this->getInstance()->findOrFail($id);
    }

    /**
     * @param array $whereClauses
     * @return mixed
     */
    public function findWhere(array $whereClauses){
        return $this->getInstance()->where($whereClauses)->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id){
        return $this->getInstance()->where(['id' => $id])->delete();
    }

    /**
     * @return mixed
     */
    public function all(){
        return $this->getInstance()->all();
    }

    /**
     * Sync relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }
}
