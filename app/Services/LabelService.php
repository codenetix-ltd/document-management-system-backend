<?php

namespace App\Services;

use App\QueryParams\IQueryParamsObject;
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
    use CRUDServiceTrait;

    /**
     * LabelService constructor.
     * @param LabelRepository $repository
     */
    public function __construct(LabelRepository $repository)
    {
        $this->setRepository($repository);

        $this->setModelCreateEventClass(LabelCreateEvent::class);
        $this->setModelUpdateEventClass(LabelUpdateEvent::class);
        $this->setModelDeleteEventClass(LabelDeleteEvent::class);
    }
}
