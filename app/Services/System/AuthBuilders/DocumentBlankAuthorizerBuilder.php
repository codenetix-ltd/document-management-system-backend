<?php

namespace App\System\AuthBuilders;

use App\Context\BlankAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentBlankAuthorizer;
use Illuminate\Support\Facades\Auth;

class DocumentBlankAuthorizerBuilder extends AAuthorizerBuilder
{
    public function build($target = null): AAuthorizer
    {
        $blankAuthorizeContext = new BlankAuthorizeContext(Auth::user());

        return new DocumentBlankAuthorizer($blankAuthorizeContext);
    }
}