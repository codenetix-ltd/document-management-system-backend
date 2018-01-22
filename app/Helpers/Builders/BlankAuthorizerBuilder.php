<?php

namespace App\Helpers\Builders;

use App\Context\BlankAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\BlankActionAuthorizer;
use Illuminate\Support\Facades\Auth;

class BlankAuthorizerBuilder extends AAuthorizerBuilder
{
    public function build($target = null): AAuthorizer
    {
        $blankAuthorizeContext = new BlankAuthorizeContext(Auth::user());

        return new BlankActionAuthorizer($blankAuthorizeContext);
    }
}