<?php

namespace Tests\Stubs;

use App\Entities\Label;

class LabelStub
{
    private $label;

    public function __construct($valuesToOverride = [], $persisted = false)
    {
        $this->label = factory(Label::class)->{$persisted ? 'create' : 'make'}($valuesToOverride);
    }

    public function buildRequest($valuesToOverride = []): array
    {
        return array_replace_recursive([
            'name' => $this->label->name,
        ], $valuesToOverride);
    }

    public function buildResponse($valuesToOverride = []): array
    {
        return array_replace_recursive([
            'name' => $this->label->name,
        ], $valuesToOverride);
    }

    public function getModel()
    {
        return $this->label;
    }
}