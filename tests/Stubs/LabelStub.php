<?php

namespace Tests\Stubs;

use App\Entities\Label;

class LabelStub
{
    private $label;

    public function __construct()
    {
        $this->label = factory(Label::class)->make();
    }

    public function buildRequest(): array
    {
        return [
            'name' => $this->label->name,
        ];
    }

    public function buildResponse(Label $labelModel): array
    {
        return [
            'id' => $labelModel->id,
            'name' => $this->label->name,
            'createdAt' => $labelModel->createdAt->timestamp,
            'updatedAt' => $labelModel->updatedAt->timestamp
        ];
    }
}