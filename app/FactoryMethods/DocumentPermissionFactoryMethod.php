<?php namespace App\FactoryMethods;
use App\Context\DocumentAuthorizeContext;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentPermissionFactoryMethod
{
    private $context;

    public function __construct(DocumentAuthorizeContext $context)
    {
        $this->context = $context;
    }

    public function make(Role $role, Permission $permission, $handlerClass){
        switch($handlerClass){
            case ByFactoryPermissionHandler::class:
                return new ByFactoryPermissionHandler($this->context->getUser(), $role, $this->context->getDocument()->factories->toBase());
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