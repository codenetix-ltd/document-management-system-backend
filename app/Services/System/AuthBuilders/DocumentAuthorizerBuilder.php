<?php

namespace App\System\AuthBuilders;

use App\Context\DocumentAuthorizeContext;
use App\Services\Authorizers\AAuthorizer;
use App\Services\Authorizers\DocumentAuthorizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentAuthorizerBuilder extends AAuthorizerBuilder
{
    /**
     * @param Model|null $target
     * @return AAuthorizer
     */
    public function build(Model $target = null): AAuthorizer
    {
        $documentAuthorizeContext = new DocumentAuthorizeContext(Auth::user(), $target);

        return new DocumentAuthorizer($documentAuthorizeContext);
    }
}
