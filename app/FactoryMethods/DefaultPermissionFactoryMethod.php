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

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DefaultPermissionFactoryMethod
{
    public function make(Role $role, Permission $permission, $handlerClass){
        switch($handlerClass){
            case AnyPermissionHandler::class:
                return new AnyPermissionHandler();
            case NonePermissionHandler::class:
                return new NonePermissionHandler();
            default:
                dump($handlerClass);
                exit();
        }
    }
}