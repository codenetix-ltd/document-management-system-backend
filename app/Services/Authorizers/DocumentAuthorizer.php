<?php

namespace App\Services\Authorizers;

use App\Context\DocumentAuthorizeContext;
use App\FactoryMethods\DocumentPermissionFactoryMethod;

class DocumentAuthorizer extends AAuthorizer
{
    public function __construct(DocumentAuthorizeContext $documentAuthorizeContext)
    {
        $this->context = $documentAuthorizeContext;
    }

    public function getAvailableTemplatesIds()
    {
        $templateIds = $this->context->getUser()->templates->pluck('id');
        foreach ($this->context->getUser()->roles as $role){
            $templateIds = $templateIds->merge($role->templates->pluck('id'));
        }

        return $templateIds->unique()->toArray();
    }

    protected function getPermissionFactoryMethod()
    {
        return (new DocumentPermissionFactoryMethod($this->context));
    }
}