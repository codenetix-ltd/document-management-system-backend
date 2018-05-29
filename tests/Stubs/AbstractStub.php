<?php

namespace Tests\Stubs;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractStub
{
    protected $model;

    /**
     * @var bool
     */
    protected $persisted;

    /**
     * @var bool
     */
    protected $replaceTimeStamps = false;

    /**
     * @return string
     */
    abstract protected function getModelName();

    /**
     * @return array
     */
    abstract protected function doBuildRequest();

    /**
     * @return array
     */
    abstract protected function doBuildResponse();

    /**
     * AbstractStub constructor.
     * @param array $valuesToOverride
     * @param bool $persisted
     * @param array $states
     * @param Model|null $model
     */
    public function __construct($valuesToOverride = [], $persisted = false, $states = [], Model $model = null)
    {
        $this->persisted = $persisted;
        if ($model) {
            $this->initiateByModel($model);
        } else {
            $this->buildModel($valuesToOverride, $persisted, $states);
        }
    }

    public function buildRequest($valuesToOverride = [])
    {
        return array_replace_recursive($this->doBuildRequest(), $valuesToOverride);
    }

    public function buildResponse($valuesToOverride = [])
    {
        $response = $this->doBuildResponse();

        if ($this->persisted) {
            $response['id'] = $this->model->id;

            if ($this->replaceTimeStamps) {
                if ($this->model->createdAt) {
                    $response['createdAt'] = $this->model->createdAt->timestamp;
                }
                if ($this->model->updatedAt) {
                    $response['updatedAt'] = $this->model->updatedAt->timestamp;
                }
            }
        }

        return array_replace_recursive($response, $valuesToOverride);
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function buildModel($valuesToOverride = [], $persisted = false, $states = [])
    {
        $this->model = factory($this->getModelName())->states($states)->{$persisted ? 'create' : 'make'}($valuesToOverride);
    }

    protected function initiateByModel($model)
    {
        $this->model = $model;
    }
}
