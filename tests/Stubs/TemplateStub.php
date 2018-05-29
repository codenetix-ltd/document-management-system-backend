<?php

namespace Tests\Stubs;

use App\Entities\Attribute;
use App\Entities\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class LabelStub
 * @package Tests\Stubs
 * @property Template $model
 */
class TemplateStub extends AbstractStub
{
    protected $replaceTimeStamps = true;

    /**
     * @var Collection
     */
    protected $attributeStubs;
    /**
     * @var bool
     */
    private $withAttributes;

    public function __construct(array $valuesToOverride = [], bool $persisted = false, array $states = [], ?Model $model = null, $withAttributes = true)
    {
        parent::__construct($valuesToOverride, $persisted, $states, $model);
        $this->withAttributes = $withAttributes;
    }

    protected function buildModel($valuesToOverride = [], $persisted = false, $states = [])
    {
        parent::buildModel($valuesToOverride, $persisted, $states);

        $this->attributeStubs = new Collection();
        for ($i=0; $i<3 && $this->withAttributes; ++$i) {
            $this->attributeStubs->push(new AttributeWithTypeStringStub(['template_id' => $this->model->id], $persisted, []));
        }
    }

    /**
     * @param Template $model
     */
    protected function initiateByModel($model)
    {
        parent::initiateByModel($model);

        $this->attributeStubs = $model->attributes->map(function (Attribute $item) {
            return new AttributeWithTypeStringStub([], true, [], $item);
        });
    }


    /**
     * @return string
     */
    protected function getModelName()
    {
        return Template::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        return [
            'name' => $this->model->name,
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        return [
            'name' => $this->model->name,
            'attributes' => $this->attributeStubs->map(function (AttributeWithTypeStringStub $item) {
                return $item->buildResponse();
            })->toArray()
        ];
    }
}
