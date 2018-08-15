<?php

namespace Tests\Stubs;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractStub
 */
abstract class AbstractStub
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var boolean
     */
    protected $persisted;

    /**
     * @var boolean
     */
    protected $replaceTimeStamps = false;

    /**
     * @var boolean
     */
    protected $metaStyle = false;

    /**
     * @var array
     */
    protected $metaData = [];

    /**
     * @param array $data
     * @return $this
     */
    public function enableMeta(array $data = []): self
    {
        $this->metaStyle = true;
        $this->metaData = $data;

        return $this;
    }

    /**
     * @return AbstractStub
     */
    public function disableMeta(): self
    {
        $this->metaStyle = false;
        $this->metaData = [];

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getModelName(): string;

    /**
     * @return array
     */
    abstract protected function doBuildRequest(): array;

    /**
     * @return array
     */
    abstract protected function doBuildResponse(): array;

    /**
     * AbstractStub constructor.
     * @param array      $valuesToOverride
     * @param boolean    $persisted
     * @param array      $states
     * @param Model|null $model
     */
    public function __construct(array $valuesToOverride = [], bool $persisted = false, array $states = [], Model $model = null)
    {
        $this->persisted = $persisted;
        if ($model) {
            $this->initiateByModel($model);
        } else {
            $this->buildModel($valuesToOverride, $persisted, $states);
        }
    }

    /**
     * @param array $valuesToOverride
     * @return array
     */
    public function buildRequest(array $valuesToOverride = []): array
    {
        return array_replace_recursive($this->doBuildRequest(), $valuesToOverride);
    }

    /**
     * @param array $valuesToOverride
     * @return array
     */
    public function buildResponse(array $valuesToOverride = []): array
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

        $result = array_replace_recursive($response, $valuesToOverride);

        if ($this->metaStyle) {
            return [
                'meta' => $this->metaData,
                'data' => $result
            ];
        }

        return $result;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param array   $valuesToOverride
     * @param boolean $persisted
     * @param array   $states
     * @return void
     */
    protected function buildModel(array $valuesToOverride = [], bool $persisted = false, array $states = []): void
    {
        $this->model = factory($this->getModelName())->states($states)->{$persisted ? 'create' : 'make'}($valuesToOverride);
    }

    /**
     * @param Model $model
     * @return void
     */
    protected function initiateByModel(Model $model): void
    {
        $this->model = $model;
    }
}
