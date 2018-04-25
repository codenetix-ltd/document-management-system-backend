<?php

namespace App\Http\Requests;

use App\Contracts\System\ITransformer;
use App\Services\Components\Validation\ValidationRulesKeeper;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    protected $updatedFields = [];

    protected $modelConfigName = '';

    public function transform(string $interface)
    {
        $object = $this->container->make($interface);
        $transformer = $this->container->make(ITransformer::class);
        $transformer->transform($this->only(array_keys($this->rules())), $object);
        $this->updatedFields = $transformer->getTransformedFields();

        return $object;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }

    public function rules() {
        return $this->modelConfigName ? (new ValidationRulesKeeper(config()))->getRules($this->modelConfigName):[];
    }
}