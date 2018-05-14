<?php

namespace App\Http\Requests;

use App\Contracts\System\ITransformer;
use App\Services\Components\Validation\ValidationRulesKeeper;
use Illuminate\Container\Container;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    protected $ignoredFields = [];

    protected $updatedFields = [];

    protected $modelConfigName = '';

    public function transform(string $interface)
    {
        $object = $this->container->make($interface);
        $transformer = $this->getTransformer();
        $transformer->transform($this->only(array_diff(array_keys($this->rules()), $this->ignoredFields)), $object);
        $this->updatedFields = $transformer->getTransformedFields();

        return $object;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failValidation()
    {
        $this->failedValidation($this->getValidatorInstance());
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }

    public function rules() {
        return $this->modelConfigName ? (new ValidationRulesKeeper(config()))->getRules($this->modelConfigName):[];
    }

    protected function getTransformer()
    {
        return $this->container->make(ITransformer::class);
    }
}