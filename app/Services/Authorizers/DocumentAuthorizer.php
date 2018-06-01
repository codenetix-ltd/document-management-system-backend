<?php

namespace App\Services\Authorizers;

use App\Context\DocumentAuthorizeContext;
use App\FactoryMethods\AbstractPermissionFactoryMethod;
use App\FactoryMethods\DocumentPermissionFactoryMethod;

class DocumentAuthorizer extends AAuthorizer
{
    /**
     * DocumentAuthorizer constructor.
     * @param DocumentAuthorizeContext $documentAuthorizeContext
     */
    public function __construct(DocumentAuthorizeContext $documentAuthorizeContext)
    {
        $this->context = $documentAuthorizeContext;
    }

    /**
     * @return array
     */
    public function getAvailableTemplatesIds()
    {
        $templateIds = $this->context->getUser()->templates->pluck('id');
        foreach ($this->context->getUser()->roles as $role) {
            $templateIds = $templateIds->merge($role->templates->pluck('id'));
        }

        return $templateIds->unique()->toArray();
    }

    /**
     * @return DocumentPermissionFactoryMethod
     */
    protected function getPermissionFactoryMethod(): AbstractPermissionFactoryMethod
    {
        return (new DocumentPermissionFactoryMethod($this->context));
    }
}
