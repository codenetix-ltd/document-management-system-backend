<?php
/**
 * Created by PhpStorm.
 * User: Sparrow
 * Date: 15/08/2018
 * Time: 10:47
 */

namespace App\Services;


use Illuminate\Support\Facades\Event;
use App\QueryParams\IQueryParamsObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait CRUDServiceTrait
{
    private $repository;

    private $modelGetEventClass;
    private $modelUpdateEventClass;
    private $modelCreateEventClass;
    private $modelDeleteEventClass;

    /**
     * @param mixed $modelGetEventClass
     */
    public function setModelGetEventClass($modelGetEventClass): void
    {
        $this->modelGetEventClass = $modelGetEventClass;
    }

    /**
     * @param mixed $modelDeleteEventClass
     */
    public function setModelDeleteEventClass($modelDeleteEventClass): void
    {
        $this->modelDeleteEventClass = $modelDeleteEventClass;
    }

    /**
     * @param mixed $modelCreateEventClass
     */
    public function setModelCreateEventClass($modelCreateEventClass): void
    {
        $this->modelCreateEventClass = $modelCreateEventClass;
    }

    /**
     * @param mixed $modelUpdateEventClass
     */
    public function setModelUpdateEventClass($modelUpdateEventClass): void
    {
        $this->modelUpdateEventClass = $modelUpdateEventClass;
    }

    /**
     * @param $repository
     */
    public function setRepository($repository){
        $this->repository = $repository;
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return mixed
     */
    public function paginate(IQueryParamsObject $queryParamsObject)
    {
        return $this->repository->paginateList($queryParamsObject);
    }

    /**
     * @param integer $id
     * @return Model
     */
    public function find(int $id)
    {
        $model = $this->repository->find($id);

        if($this->modelGetEventClass){
            Event::dispatch(new $this->modelGetEventClass($model));
        }

        return $model;
    }

    /**
     * @return Collection
     */
    public function list()
    {
        return $this->repository->all();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        /** @var Model $model */
        $model = $this->repository->create($data);

        if($this->modelCreateEventClass){
            Event::dispatch(new $this->modelCreateEventClass($model));
        }

        return $model;
    }

    /**
     * @param array $data
     * @param integer $id
     * @return Model
     */
    public function update(array $data, int $id)
    {
        /** @var Model $model */
        $model = $this->repository->update($data, $id);

        if($this->modelUpdateEventClass){
            Event::dispatch(new $this->modelUpdateEventClass($model));
        }

        return $model;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): ?int
    {
        try {
            $model = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        if($this->modelDeleteEventClass){
            Event::dispatch(new $this->modelDeleteEventClass($model));
        }

        return $this->repository->delete($id);
    }
}