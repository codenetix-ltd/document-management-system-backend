<?php namespace App\FactoryMethods;
use App\Context\DocumentAuthorizeContext;
use App\Context\UserAuthorizeContext;
use App\Document;
use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\ByFactoryPermissionHandler;
use App\Handlers\Permissions\ByIdPermissionHandler;
use App\Handlers\Permissions\ByOwnerPermissionHandler;
use App\Handlers\Permissions\ByQualifiersPermissionHandler;
use App\Handlers\Permissions\ByTemplatePermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;
use App\Permission;
use App\Role;
use RuntimeException;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class UserPermissionFactoryMethod
{
    private $context;

    public function __construct(UserAuthorizeContext $context)
    {
        $this->context = $context;
    }

    public function make(Role $role, Permission $permission, $handlerClass){
        switch($handlerClass){
            case AnyPermissionHandler::class:
                return new AnyPermissionHandler();
            case NonePermissionHandler::class:
                return new NonePermissionHandler();
            case ByOwnerPermissionHandler::class:
                return new ByOwnerPermissionHandler($this->context->getUser(), $this->context->getSubjectUser());
            default:
                throw new RuntimeException("Unsupported handlerClass provided");
        }
    }
}