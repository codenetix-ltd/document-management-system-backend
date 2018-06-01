<?php

namespace App\System\AuthBuilders;

use App\Context\UserAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\UserAuthorizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserAuthorizerBuilder extends AAuthorizerBuilder
{
    /**
     * @param Model|null $target
     * @return AAuthorizer
     */
    public function build(Model $target = null): AAuthorizer
    {
        $userAuthorizeContext = new UserAuthorizeContext(Auth::user(), $target);

        return new UserAuthorizer($userAuthorizeContext);
    }
}
