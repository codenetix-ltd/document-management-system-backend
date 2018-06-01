<?php

namespace App\System\AuthBuilders;

use App\Context\BlankAuthorizeContext;
use App\Context\DocumentAuthorizeContext;
use App\Context\UserAuthorizeContext;
use App\Services\Authorizers\DefaultAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use App\Services\Authorizers\UserAuthorizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthorizerFactory
{
    /**
     * @param string $type
     * @param Model  $target
     * @return DefaultAuthorizer|DocumentAuthorizer|UserAuthorizer
     */
    public static function make(string $type = null, Model $target = null)
    {
        switch ($type) {
            case 'document':
                $documentAuthorizeContext = new DocumentAuthorizeContext(Auth::user(), $target);
                return new DocumentAuthorizer($documentAuthorizeContext);
            case 'user':
                $userAuthorizeContext = new UserAuthorizeContext(Auth::user(), $target);
                return new UserAuthorizer($userAuthorizeContext);
            default:
                $context = new BlankAuthorizeContext(Auth::user());
                return new DefaultAuthorizer($context);
        }
    }
}
