<?php

namespace App\Http\Requests\User;

use App\Contracts\Models\IUser;
use App\Contracts\Transformers\IUserRequestTransformer;
use Illuminate\Foundation\Http\FormRequest;

class UserBaseRequest extends FormRequest implements IUserRequestTransformer
{
    private $updatedFields = [];

    public function getEntity(): IUser
    {
        $user = $this->container->make(IUser::class);

        foreach ($this->all() as $fieldKey => $fieldValue) {
            $methodName = 'set' . ucfirst(camel_case($fieldKey));
            if (method_exists($user, $methodName)) {
                $user->{$methodName}($fieldValue);
                array_push($this->updatedFields, $fieldKey);
            }
        }

        return $user;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }
}