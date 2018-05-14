<?php

namespace App\System\AuthBuilders;

use App\Context\UserAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\UserAuthorizer;
use Illuminate\Support\Facades\Auth;

class UserAuthorizerBuilder extends AAuthorizerBuilder
{
    public function build($target = null): AAuthorizer
    {
        $userAuthorizeContext = new UserAuthorizeContext(Auth::user(), $target);

        return new UserAuthorizer($userAuthorizeContext);
    }
}
