<?php

namespace App\Services\Authorizers;

use App\Context\BlankAuthorizeContext;
use App\FactoryMethods\AbstractPermissionFactoryMethod;
use App\FactoryMethods\DefaultPermissionFactoryMethod;

class DefaultAuthorizer extends AAuthorizer
{

    /**
     * DefaultAuthorizer constructor.
     * @param BlankAuthorizeContext $context
     */
    public function __construct(BlankAuthorizeContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return DefaultPermissionFactoryMethod
     */
    protected function getPermissionFactoryMethod(): AbstractPermissionFactoryMethod
    {
        return new DefaultPermissionFactoryMethod();
    }
}
