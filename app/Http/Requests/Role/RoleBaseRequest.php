<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\ApiRequest;
use App\Role;
use App\Services\System\EloquentTransformer;

class RoleBaseRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getEntity(): Role
    {
        return $this->transform(Role::class);
    }

    public function transform(string $interface)
    {
        $data = $this->only(array_keys($this->rules()));
        /** @var Role $object */
        $object = $this->container->make($interface);
        $transformer = $this->container->make(EloquentTransformer::class);
        $transformer->transform($data, $object);

        return $object;

    }


}
