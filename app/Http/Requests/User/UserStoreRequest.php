<?php

namespace App\Http\Requests\User;

use App\Context\UserAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\UserAuthorizer;
use Illuminate\Support\Facades\Auth;

class UserStoreRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('user_create');
    }

    /**
     * @return AAuthorizer
     */
    protected function getAuthorizer(): AAuthorizer
    {
        return new UserAuthorizer(new UserAuthorizeContext(Auth::user()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string|max:255|min:6',
            'passwordConfirmation' => 'required|same:password',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'templatesIds' => 'sometimes|array',
            'templatesIds.*' => 'integer|exists:templates,id',
            'rolesIds' => 'sometimes|array',
            'rolesIds.*' => 'integer|exists:roles,id',
            'avatarId' => 'sometimes|integer|exists:files,id'
        ];
    }
}
