<?php

namespace App\Http\Requests;

use App\Context\BlankAuthorizeContext;
use App\QueryParams\EmptyQueryParamsObject;
use App\QueryParams\IQueryParamsObject;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DefaultAuthorizer;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class ABaseAPIRequest extends Request implements ValidatesWhenResolved
{

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;


    protected $queryParamsObjectInstance;

    protected $cachedModel = null;

    /**
     * Create the validator factory instance for the request.
     *
     * @return ValidationFactory
     */
    protected function createValidatorFactory(): ValidationFactory
    {
        return $this->container->make(ValidationFactory::class);
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory): Validator
    {
        return $factory->make(
            $this->post(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        );
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createQueryParamsValidator(ValidationFactory $factory): Validator
    {
        $queryParamsObject = $this->queryParamsObject();

        return $factory->make(
            $this->query(), $this->extractsQueryParamsRulesFromObject($queryParamsObject),
            $this->messages(), $this->attributes()
        );
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @return array
     */
    public function extractsQueryParamsRulesFromObject(IQueryParamsObject $queryParamsObject):array {
        $rules = [];

        foreach ($queryParamsObject->getAllowedFieldsToSort() as $key){
            $rules['sort.'.$key] = ['in:desc,asc'];
        }

        foreach ($queryParamsObject->getAllowedFieldsToFilter() as $key => $currentRules){
            $rules['filter.'.$key] = $currentRules;
        }

        return $rules;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated(): array
    {
        $rules = $this->container->call([$this, 'rules']);

        return $this->only(collect($rules)->keys()->map(function ($rule) {
            return explode('.', $rule)[0];
        })->unique()->toArray());
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Set the container implementation.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return $this
     */
    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Validate the class instance.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateResolved(): void
    {
        if(!$this->authorize($this->model())){
            throw new AccessDeniedHttpException();
        }

        $factoryInstance = $this->createValidatorFactory();
        $bodyValidatorInstance = $this->createDefaultValidator($factoryInstance);
        $queryValidatorInstance = $this->createQueryParamsValidator($factoryInstance);

        if (! $bodyValidatorInstance->passes()) {
            $this->failedValidation($bodyValidatorInstance);
        } elseif(! $queryValidatorInstance->passes()){
            $this->failedValidation($queryValidatorInstance);
        }
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }

    /**
     * @return IQueryParamsObject
     */
    public function queryParamsObject(): IQueryParamsObject
    {
        return $this->queryParamsObjectInstance ?: $this->createQueryParamsObject();
    }

    /**
     * @return IQueryParamsObject
     */
    protected function createQueryParamsObject(): IQueryParamsObject
    {
        return new EmptyQueryParamsObject([], [], [], []);
    }

    /**
     * @return AAuthorizer
     */
    protected function getAuthorizer(){
        return new DefaultAuthorizer(new BlankAuthorizeContext(Auth::user()));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * @return mixed|null
     */
    public function model(){
        if(!$this->cachedModel && method_exists($this, 'getTargetModel')){
            $this->cachedModel = $this->container->call([$this, 'getTargetModel']);
        }

        return $this->cachedModel;
    }

    /**
     * @return array
     */
    public function rules(){
        return [];
    }

    /**
     * @return array
     */
    public function filtered()
    {
        return $this->only(array_keys($this->rules()));
    }
}