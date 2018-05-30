<?php

namespace App\Services;

use App\Entities\Label;
use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use App\Repositories\LabelRepository;
use Illuminate\Support\Facades\Event;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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

    public function delete(int $id)
    {
        $label = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($label)) {
            return null;
        }

        $this->repository->delete($id);
        Event::dispatch(new LabelDeleteEvent($label));
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }
}
