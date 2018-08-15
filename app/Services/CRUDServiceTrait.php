<?php
namespace App\Services;

use Illuminate\Support\Facades\Event;
use App\QueryParams\IQueryParamsObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait CRUDServiceTrait
{

    /**
     * @var mixed
     */
    private $repository;

    /**
     * @var string
     */
    private $modelGetEventClass;

    /**
     * @var string
     */
    private $modelUpdateEventClass;

    /**
     * @var string
     */
    private $modelCreateEventClass;

    /**
     * @var string
     */
    private $modelDeleteEventClass;

    /**
     * @param string $modelGetEventClass
     * @return void
     */
    public function setModelGetEventClass(string $modelGetEventClass): void
    {
        $this->modelGetEventClass = $modelGetEventClass;
    }

    /**
     * @param string $modelDeleteEventClass
     * @return void
     */
    public function setModelDeleteEventClass(string $modelDeleteEventClass): void
    {
        $this->modelDeleteEventClass = $modelDeleteEventClass;
    }

    /**
     * @param string $modelCreateEventClass
     * @return void
     */
    public function setModelCreateEventClass(string $modelCreateEventClass): void
    {
        $this->modelCreateEventClass = $modelCreateEventClass;
    }

    /**
     * @param string $modelUpdateEventClass
     * @return void
     */
    public function setModelUpdateEventClass(string $modelUpdateEventClass): void
    {
        $this->modelUpdateEventClass = $modelUpdateEventClass;
    }

    /**
     * @param mixed $repository
     * @return void
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return Collection
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

        if ($this->modelGetEventClass) {
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

        if ($this->modelCreateEventClass) {
            Event::dispatch(new $this->modelCreateEventClass($model));
        }

        return $model;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Model
     */
    public function update(array $data, int $id)
    {
        /** @var Model $model */
        $model = $this->repository->update($data, $id);

        if ($this->modelUpdateEventClass) {
            Event::dispatch(new $this->modelUpdateEventClass($model));
        }

        return $model;
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): ?bool
    {
        try {
            $model = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        if ($this->modelDeleteEventClass) {
            Event::dispatch(new $this->modelDeleteEventClass($model));
        }

        return $this->repository->delete($id);
    }
}
