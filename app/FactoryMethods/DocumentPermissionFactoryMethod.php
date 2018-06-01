<?php

namespace App\FactoryMethods;

use App\Context\DocumentAuthorizeContext;
use App\Entities\Permission;
use App\Entities\Role;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\ByOwnerPermissionHandler;
use App\Handlers\Permissions\ByQualifiersPermissionHandler;
use App\Handlers\Permissions\ByTemplatePermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;
use Illuminate\Support\Collection;
use RuntimeException;

class DocumentPermissionFactoryMethod extends AbstractPermissionFactoryMethod
{
    /**
     * @var DocumentAuthorizeContext
     */
    private $context;

    /**
     * DocumentPermissionFactoryMethod constructor.
     * @param DocumentAuthorizeContext $context
     */
    public function __construct(DocumentAuthorizeContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param Role       $role
     * @param Permission $permission
     * @param string     $handlerClass
     * @return AnyPermissionHandler|ByOwnerPermissionHandler|ByQualifiersPermissionHandler|ByTemplatePermissionHandler|NonePermissionHandler|mixed
     */
    public function make(Role $role, Permission $permission, string $handlerClass)
    {
        switch ($handlerClass) {
            case ByTemplatePermissionHandler::class:
                return new ByTemplatePermissionHandler($this->context->getUser(), $role, new Collection([$this->context->getDocument()->template]));
            case ByOwnerPermissionHandler::class:
                return new ByOwnerPermissionHandler($this->context->getUser(), $this->context->getDocument());
            case AnyPermissionHandler::class:
                return new AnyPermissionHandler();
            case NonePermissionHandler::class:
                return new NonePermissionHandler();
            case ByQualifiersPermissionHandler::class:
                return new ByQualifiersPermissionHandler($this->context, $role, $this, $permission);
            default:
                throw new RuntimeException("Unsupported handlerClass provided");
        }
    }
}
