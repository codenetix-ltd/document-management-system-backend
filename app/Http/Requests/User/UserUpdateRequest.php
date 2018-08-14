<?php

namespace App\Http\Requests\User;

use App\Context\UserAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\UserAuthorizer;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('user_update');
    }

    /**
     * @return UserAuthorizer
     */
    protected function getAuthorizer()
    {
        return new UserAuthorizer(new UserAuthorizeContext(Auth::user(), $this->model()));
    }

    /**
     * @param UserService $userService
     * @return mixed
     */
    public function getTargetModel(UserService $userService)
    {
        return $userService->find($this->route()->parameter('user'));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->route('user'),
            'templatesIds' => 'sometimes|array',
            'templatesIds.*' => 'integer|exists:templates,id',
            'rolesIds' => 'sometimes|array',
            'rolesIds.*' => 'integer|exists:roles,id',
            'avatarId' => 'sometimes|integer|exists:files,id'
        ];
    }
}
