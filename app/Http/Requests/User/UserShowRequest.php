<?php

namespace App\Http\Requests\User;

use App\Context\UserAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\UserAuthorizer;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return $this->getAuthorizer()->check('user_view');
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
        $id = $this->route()->parameter('user');

        if ($id === 'current') {
            $id = Auth::user()->id;
        }
        return $userService->find($id);
    }
}
