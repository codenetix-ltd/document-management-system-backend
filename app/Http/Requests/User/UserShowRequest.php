<?php

namespace App\Http\Requests\User;

use App\Context\UserAuthorizeContext;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\UserAuthorizer;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserShowRequest extends ABaseAPIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return $this->getAuthorizer()->check('user_view');
    }

    /**
     * @return UserAuthorizer
     */
    protected function getAuthorizer(): AAuthorizer
    {
        return new UserAuthorizer(new UserAuthorizeContext(Auth::user(), $this->model()));
    }

    /**
     * @param UserService $userService
     * @return Model
     */
    public function getTargetModel(UserService $userService): Model
    {
        $id = $this->route()->parameter('user');

        if ($id === 'current') {
            $id = Auth::user()->id;
        }
        return $userService->find($id);
    }
}
