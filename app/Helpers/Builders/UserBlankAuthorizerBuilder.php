<?php

namespace App\Helpers\Builders;

use App\Context\BlankAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\UserBlankAuthorizer;
use Illuminate\Support\Facades\Auth;

class UserBlankAuthorizerBuilder extends AAuthorizerBuilder
{
    public function build($target = null): AAuthorizer
    {
        $blankAuthorizeContext = new BlankAuthorizeContext(Auth::user());

        return new UserBlankAuthorizer($blankAuthorizeContext);
    }
}