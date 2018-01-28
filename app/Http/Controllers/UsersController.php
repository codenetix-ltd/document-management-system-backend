<?php

namespace App\Http\Controllers;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\CommandInvokers\ITransactionCommandInvoker;
use App\Contracts\Commands\Factory\IFactoryListCommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Commands\User\IUserDeleteCommand;
use App\Contracts\Commands\User\IUserGetCommand;
use App\Contracts\Commands\Paginators\IUserPaginatorCommand;
use App\Contracts\Commands\Role\IRoleListCommand;
use App\Contracts\Services\IUserCreateService;
use App\Contracts\Services\IUserUpdateService;
use App\Helpers\Builders\AuthorizerFactory;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Container\Container;

class UsersController extends Controller
{
    public function update($id, UserStoreRequest $request, Container $container, ITransactionCommandInvoker $invoker)
    {
        $data = $this->filterOnNull($request->all());

        $userUpdateService = app()->makeWith(IUserUpdateService::class, [
            'container' => $container,
            'id' => $id,
            'userData' => $data,
            'file' => $request->file('file')
        ]);
        $invoker->invoke($userUpdateService);
        $user = $userUpdateService->getResult();

        return redirect()->route('users.list')->with('success', 'User ' . $user->full_name . ' has been updated with success!');
    }

    /**
     * @param $id
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, IAtomCommandInvoker $invoker)
    {
        $userGetCommand = app()->makeWith(IUserGetCommand::class, [
            'id' => $id
        ]);
        $invoker->invoke($userGetCommand);
        $user = $userGetCommand->getResult();

        $authorizer = AuthorizerFactory::make('user', $user);
        $authorizer->authorize('user_delete');

        if ($user->documents->count()) {
            return back()->with('error', 'Unable to remove user "' . $user->full_name . '" as long as he has at least one document!');
        }

        $userDeleteCommand = app()->makeWith(IUserDeleteCommand::class, [
            'id' => $user->id
        ]);
        $invoker->invoke($userDeleteCommand);

        return back()->with('success', 'User "' . $user->full_name . '" has been removed with success!');
    }

    /**
     * @param IAtomCommandInvoker $invoker
     * @param IUserPaginatorCommand $userPaginatorCommand
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IAtomCommandInvoker $invoker, IUserPaginatorCommand $userPaginatorCommand)
    {
        $invoker->invoke($userPaginatorCommand);
        $users = $userPaginatorCommand->getResult();

        return view('pages.users.list', compact('users'));
    }

    /**
     * @param $id
     * @param IAtomCommandInvoker $invoker
     * @param Container $container
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, IAtomCommandInvoker $invoker, Container $container)
    {
        $userGetCommand = app()->makeWith(IUserGetCommand::class, [
            'id' => $id
        ]);
        $invoker->invoke($userGetCommand);
        $model = $userGetCommand->getResult();

        $authorizer = AuthorizerFactory::make('user', $model);
        $authorizer->authorize('user_update');

        $roleListCommand = app()->makeWith(IRoleListCommand::class, []);
        $invoker->invoke($roleListCommand);
        $roles = $roleListCommand->getResult();

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

        return view('pages.users.add_edit', compact('model', 'roles', 'factories', 'templates'));
    }

    /**
     * @param IAtomCommandInvoker $invoker
     * @param Container $container
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(IAtomCommandInvoker $invoker, Container $container)
    {
        $authorizer = AuthorizerFactory::make('user');
        $authorizer->authorize('user_create');

        $roleListCommand = app()->makeWith(IRoleListCommand::class, []);
        $invoker->invoke($roleListCommand);
        $roles = $roleListCommand->getResult();

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

        return view('pages.users.add_edit', compact('roles', 'factories', 'templates'));
    }

    /**
     * @param $id
     * @param IAtomCommandInvoker $invoker
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProfile($id, IAtomCommandInvoker $invoker)
    {
        $userGetCommand = app()->makeWith(IUserGetCommand::class, [
            'id' => $id
        ]);
        $invoker->invoke($userGetCommand);
        $model = $userGetCommand->getResult();

        $authorizer = AuthorizerFactory::make('user', $model);
        $authorizer->authorize('user_update');

        $factoryListCommand = app()->makeWith(IFactoryListCommand::class, [
            'columns' => ['id', 'name']
        ]);
        $invoker->invoke($factoryListCommand);
        $factories = $factoryListCommand->getResult();

        return view('pages.profile.edit', compact('model', 'roles', 'factories'));
    }

    /**
     * @param $id
     * @param ProfileUpdateRequest $request
     * @param Container $container
     * @param IAtomCommandInvoker $atomCommandInvoker
     * @param ITransactionCommandInvoker $transactionCommandInvoker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile($id, ProfileUpdateRequest $request, Container $container, IAtomCommandInvoker $atomCommandInvoker, ITransactionCommandInvoker $transactionCommandInvoker)
    {
        $userGetCommand = app()->makeWith(IUserGetCommand::class, [
            'id' => $id
        ]);
        $atomCommandInvoker->invoke($userGetCommand);
        $model = $userGetCommand->getResult();
        $authorizer = AuthorizerFactory::make('user', $model);
        $authorizer->authorize('user_update');

        $data = $this->filterOnNull($request->all());

        $userUpdateService = app()->makeWith(IUserUpdateService::class, [
            'container' => $container,
            'id' => $id,
            'userData' => $data,
            'file' => $request->file('file')
        ]);
        $transactionCommandInvoker->invoke($userUpdateService);
        $user = $userUpdateService->getResult();

        return redirect()->route('profile.edit', ['id' => $user->id]);
    }
}
