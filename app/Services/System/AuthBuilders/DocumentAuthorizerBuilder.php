<?php

namespace App\System\AuthBuilders;

use App\Context\DocumentAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use Illuminate\Support\Facades\Auth;

class DocumentAuthorizerBuilder extends AAuthorizerBuilder
{
    public function build($target = null): AAuthorizer
    {
        $documentAuthorizeContext = new DocumentAuthorizeContext(Auth::user(), $target);

        return new DocumentAuthorizer($documentAuthorizeContext);
    }
}