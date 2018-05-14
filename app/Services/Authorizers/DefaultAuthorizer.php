<?php

namespace App\Services\Authorizers;

use App\Context\BlankAuthorizeContext;
use App\FactoryMethods\DefaultPermissionFactoryMethod;

class DefaultAuthorizer extends AAuthorizer
{
    public function __construct(BlankAuthorizeContext $context)
    {
        $this->context = $context;
    }

    protected function getPermissionFactoryMethod()
    {
        return new DefaultPermissionFactoryMethod();
    }
}