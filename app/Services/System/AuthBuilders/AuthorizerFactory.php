<?php

namespace App\Services\System\AuthBuilders;

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
                return new DocumentAuthorizer(new DocumentAuthorizeContext(Auth::user(), $target));
            case 'user':
                return new UserAuthorizer(new UserAuthorizeContext(Auth::user(), $target));
            default:
                return new DefaultAuthorizer(new BlankAuthorizeContext(Auth::user()));
        }
    }
}
