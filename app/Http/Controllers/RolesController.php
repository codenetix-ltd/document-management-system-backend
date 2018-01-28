<?php

namespace App\Http\Controllers;

use App\CommandInvokers\TransactionCommandInvoker;
use App\Contracts\Commands\Paginators\IRolePaginatorCommand;
use App\Contracts\Commands\Role\IRoleCreateCommand;
use App\Contracts\Commands\Role\IRoleDeleteCommand;
use App\Contracts\Commands\Role\IRoleGetCommand;
use App\Contracts\Commands\Role\IRoleUpdateCommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Services\IAssignPermissionToRoleService;
use App\Contracts\Services\IPermissionService;
use App\Entity\Permissions\PermissionAccessTypeValue;
use App\Entity\Permissions\PermissionQualifierValue;
use App\Helpers\Builders\AuthorizerFactory;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Services\PermissionsUpdateService;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class RolesController
 * @package App\Http\Controllers
 */
class RolesController extends Controller
{
    public function index(IRolePaginatorCommand $command)
    {
        $command->execute();
        $roles = $command->getResult();

        return view('pages.roles.list', compact('roles'));
    }

    /**
     * @param Container $container
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Container $container)
    {
        $authorizer = AuthorizerFactory::make('role');
        $authorizer->authorize('role_create');

        $templateListCommand = app()->makeWith(ITemplateListCommand::class, [
            'columns' => ['id', 'name'],
            'container' => $container
        ]);
        $templateListCommand->execute();
        $templates = $templateListCommand->getResult();

        return view('pages.roles.add_edit', compact( 'templates'));
    }

    public function store(RoleCreateRequest $request)
    {
        $data = $this->filterOnNull($request->all());

        $roleCreateCommand = app()->makeWith(IRoleCreateCommand::class, [
            'inputData' => $data
        ]);
        $roleCreateCommand->execute();
        $role = $roleCreateCommand->getResult();

        return redirect()->route('roles.edit', ['id' => $role->id])->with('success', 'Role ' . $role->name . ' has been created with success!');
    }

    /**
     * @param $id
     * @param Container $container
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Container $container)
    {
        $authorizer = AuthorizerFactory::make('role');
        $authorizer->authorize('role_update');

        $roleGetCommand = app()->makeWith(IRoleGetCommand::class, [
            'id' => $id
        ]);
        $roleGetCommand->execute();
        $role = $roleGetCommand->getResult();

        $permissionService = app()->make(IPermissionService::class);
        $permissionGroups = $permissionService->getPermissionGroups();
        $accessTypesByPermissionIds = $permissionService->getAccessTypesByPermissionId();

        $factoryListCommand = app()->makeWith(IFactoryListCommand::class, [
            'columns' => ['id', 'name'],
            'container' => $container
        ]);
        $factoryListCommand->execute();
        $factories = $factoryListCommand->getResult();

        $templateListCommand = app()->makeWith(ITemplateListCommand::class, [
            'columns' => ['id', 'name'],
            'container' => $container
        ]);
        $templateListCommand->execute();
        $templates = $templateListCommand->getResult();

        return view('pages.roles.add_edit', compact('role', 'permissionGroups', 'factories', 'templates', 'accessTypesByPermissionIds'));
    }

    public function update($id, RoleUpdateRequest $request, Container $container)
    {
        $data = $this->filterOnNull($request->all());

        $roleUpdateCommand = app()->makeWith(IRoleUpdateCommand::class, [
            'id' => $id,
            'inputData' => $data,
        ]);
        $roleUpdateCommand->execute();
        $role = $roleUpdateCommand->getResult();


        $permissionAccessTypeValues = new Collection();
        $permissionAccessTypeValuesRaw = $request->get('access_type');
        foreach ($permissionAccessTypeValuesRaw as $permissionId => $accessType){
            $permissionAccessTypeValue = new PermissionAccessTypeValue();
            $permissionAccessTypeValue->setAccessType($accessType);
            $permissionAccessTypeValue->setPermissionId($permissionId);

            if($accessType == 'by_qualifiers'){
                $permissionQualifierValues = new Collection();
                $permissionQualifierValuesRaw = $request->get('qualifier')[$permissionId];
                foreach ($permissionQualifierValuesRaw as $qualifierId => $qualifierAccessType){
                    $permissionQualifierValue = new PermissionQualifierValue();
                    $permissionQualifierValue->setId($qualifierId);
                    $permissionQualifierValue->setAccessType($qualifierAccessType);
                    $permissionQualifierValues->push($permissionQualifierValue);
                }
                $permissionAccessTypeValue->setQualifiers($permissionQualifierValues);
            }

            $permissionAccessTypeValues->push($permissionAccessTypeValue);
        }

        $permissionsUpdateService = new PermissionsUpdateService($container, $role, $permissionAccessTypeValues);
        $permissionsUpdateService->execute();

        return redirect()->route('roles.edit', ['id' => $role->id])->with('success', 'Role ' . $role->label . ' has been updated with success!');
    }

    public function postAssignPermission($id, Request $request, TransactionCommandInvoker $invoker, Container $container)
    {
        $permissionToRoleService = $container->makeWith(IAssignPermissionToRoleService::class, [
            'container' => $container,
            'inputData' => $request->all(),
            'roleId' => $id
        ]);
        $invoker->invoke($permissionToRoleService);

        return redirect()->route('roles.edit', ['id' => $id])->with('success', 'Permission has been attached with success!');
    }

    public function getDetachPermission($id, $relationId)
    {
        $roleGetCommand = app()->makeWith(IRoleGetCommand::class, [
            'id' => $id
        ]);
        $roleGetCommand->execute();
        $role = $roleGetCommand->getResult();

        $role->permissions()->wherePivot('id', $relationId)->detach();

        return redirect()->route('roles.edit', ['id' => $id])->with('success', 'Permission has been removed with success!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $roleGetCommand = app()->makeWith(IRoleGetCommand::class, [
            'id' => $id
        ]);
        $roleGetCommand->execute();
        $role = $roleGetCommand->getResult();

        if ($role->users->count()) {
            return back()->with('error', 'Unable to remove role "' . $role->label . '" as long as it has at least one user which use this role!');
        }

        $roleDeleteCommand = app()->makeWith(IRoleDeleteCommand::class, [
            'id' => $role->id
        ]);
        $roleDeleteCommand->execute();

        return back()->with('success', 'Role "' . $role->label . '" has been removed with success!');
    }

    public function getPermissionsList($roleId)
    {
        $roleGetCommand = app()->makeWith(IRoleGetCommand::class, [
            'id' => $roleId
        ]);
        $roleGetCommand->execute();
        $role = $roleGetCommand->getResult();

        return view('pages.roles.partials.permission_list', compact('role'));
    }
}
