<?php

namespace Tests\Stubs;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractStub
{
    protected $model;

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
     */
    public function __construct($valuesToOverride = [], $persisted = false, $states = [])
    {
        $this->model = factory($this->getModelName())->states($states)->{$persisted ? 'create' : 'make'}($valuesToOverride);
    }

    public function buildRequest($valuesToOverride = [])
    {
        return array_replace_recursive($this->doBuildRequest(), $valuesToOverride);
    }

    public function buildResponse($valuesToOverride = [])
    {
        return array_replace_recursive($this->doBuildResponse(), $valuesToOverride);
    }

    public function getModel()
    {
        return $this->model;
    }
}
