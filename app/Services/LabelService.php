<?php

namespace App\Services;

use App\Criteria\IQueryParamsObject;
use App\Entities\Label;
use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use App\Repositories\LabelRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;

class LabelService
{
    /**
     * @var LabelRepository
     */
    protected $repository;

    /**
     * LabelService constructor.
     * @param LabelRepository $repository
     */
    public function __construct(LabelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }

    /**
     * @param integer $id
     * @return Label
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Label
     */
    public function create(array $data)
    {
        $label = $this->repository->create($data);
        Event::dispatch(new LabelCreateEvent($label));

        return $label;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $label = $this->repository->update($data, $id);
        Event::dispatch(new LabelUpdateEvent($label));

        return $label;
    }

    /**
     * @param integer $id
     * @return integer
     */
    public function delete(int $id): ?int
    {
        try {
            $label = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        Event::dispatch(new LabelDeleteEvent($label));

        return $this->repository->delete($id);
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return mixed
     */
    public function paginate(IQueryParamsObject $queryParamsObject)
    {
        return $this->repository->paginateList($queryParamsObject);
    }
}
