<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Entities\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class LabelStub
 * @property Template $model
 */
class TemplateStub extends AbstractStub
{
    /**
     * @var boolean
     */
    protected $replaceTimeStamps = true;

    /**
     * @var Collection
     */
    protected $attributeStubs;
    /**
     * @var bool $withAttributes
     */
    private $withAttributes;

    /**
     * TemplateStub constructor.
     * @param array      $valuesToOverride
     * @param boolean    $persisted
     * @param array      $states
     * @param Model|null $model
     * @param boolean    $withAttributes
     */
    public function __construct(array $valuesToOverride = [], bool $persisted = false, array $states = [], ?Model $model = null, bool $withAttributes = true)
    {
        $this->withAttributes = $withAttributes;
        parent::__construct($valuesToOverride, $persisted, $states, $model);
    }

    /**
     * @param array   $valuesToOverride
     * @param boolean $persisted
     * @param array   $states
     * @return void
     */
    protected function buildModel(array $valuesToOverride = [], bool $persisted = false, array $states = []): void
    {
        parent::buildModel($valuesToOverride, $persisted, $states);
        $this->attributeStubs = new Collection();
        for ($i = 0; $i < 3 && $this->withAttributes; ++$i) {
            $this->attributeStubs->push(new AttributeWithTypeStringStub(['template_id' => $this->model->id], $persisted, []));
        }
    }

    /**
     * @param Model $model
     * @return void
     */
    protected function initiateByModel(Model $model): void
    {
        parent::initiateByModel($model);

        $this->attributeStubs = $model->attributes->map(function (Attribute $item) {
            return new AttributeWithTypeStringStub([], true, [], $item);
        });
    }

    /**
     * @return string
     */
    protected function getModelName(): string
    {
        return Template::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest(): array
    {
        return [
            'name' => $this->model->name,
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse(): array
    {
        return [
            'name' => $this->model->name,
            'attributes' => $this->attributeStubs->map(function (AttributeWithTypeStringStub $item) {
                return $item->buildResponse();
            })->toArray()
        ];
    }
}
