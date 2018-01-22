<?php

namespace App\Providers;

use App\Adapters\TableAdapter;
use App\CommandInvokers\AtomCommandInvoker;
use App\CommandInvokers\TransactionCommandInvoker;
use App\Commands\Document\DocumentDeleteCommand;
use App\Commands\Document\DocumentGetCommand;
use App\Commands\Document\DocumentsDeleteCommand;
use App\Commands\DocumentVersion\DocumentVersionDeleteCommand;
use App\Commands\DocumentVersion\DocumentVersionGetCommand;
use App\Commands\Factory\FactoryListCommand;
use App\Commands\Label\LabelCreateCommand;
use App\Commands\Label\LabelDeleteCommand;
use App\Commands\Label\LabelGetCommand;
use App\Commands\Label\LabelListCommand;
use App\Commands\Label\LabelUpdateCommand;
use App\Commands\Paginators\DocumentPaginatorCommand;
use App\Commands\Paginators\LabelPaginatorCommand;
use App\Commands\Paginators\RolePaginatorCommand;
use App\Commands\Paginators\TemplatePaginatorCommand;
use App\Commands\Paginators\UserPaginatorCommand;
use App\Commands\Role\RoleCreateCommand;
use App\Commands\Role\RoleDeleteCommand;
use App\Commands\Role\RoleGetCommand;
use App\Commands\Role\RoleListCommand;
use App\Commands\Role\RoleUpdateCommand;
use App\Commands\Tag\TagListCommand;
use App\Commands\Template\TemplateCreateCommand;
use App\Commands\Template\TemplateDeleteCommand;
use App\Commands\Template\TemplateGetCommand;
use App\Commands\Template\TemplateListCommand;
use App\Commands\Template\TemplateUpdateCommand;
use App\Commands\Type\TypeListCommand;
use App\Commands\User\UserCreateCommand;
use App\Commands\User\UserDeleteCommand;
use App\Commands\User\UserGetCommand;
use App\Commands\User\UserListCommand;
use App\Commands\User\UserSetAvatarCommand;
use App\Commands\User\UserUpdateCommand;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\CommandInvokers\ITransactionCommandInvoker;
use App\Contracts\Commands\Document\IDocumentDeleteCommand;
use App\Contracts\Commands\Document\IDocumentGetCommand;
use App\Contracts\Commands\Document\IDocumentsDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionGetCommand;
use App\Contracts\Commands\Factory\IFactoryListCommand;
use App\Contracts\Commands\Label\ILabelCreateCommand;
use App\Contracts\Commands\Label\ILabelDeleteCommand;
use App\Contracts\Commands\Label\ILabelGetCommand;
use App\Contracts\Commands\Label\ILabelListCommand;
use App\Contracts\Commands\Label\ILabelUpdateCommand;
use App\Contracts\Commands\Paginators\IDocumentPaginatorCommand;
use App\Contracts\Commands\Paginators\ILabelPaginatorCommand;
use App\Contracts\Commands\Paginators\IRolePaginatorCommand;
use App\Contracts\Commands\Paginators\ITemplatePaginatorCommand;
use App\Contracts\Commands\Role\IRoleCreateCommand;
use App\Contracts\Commands\Role\IRoleDeleteCommand;
use App\Contracts\Commands\Role\IRoleGetCommand;
use App\Contracts\Commands\Role\IRoleUpdateCommand;
use App\Contracts\Commands\Tag\ITagListCommand;
use App\Contracts\Commands\Template\ITemplateCreateCommand;
use App\Contracts\Commands\Template\ITemplateDeleteCommand;
use App\Contracts\Commands\Template\ITemplateGetCommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Commands\Template\ITemplateUpdateCommand;
use App\Contracts\Commands\Type\ITypeListCommand;
use App\Contracts\Commands\User\IUserCreateCommand;
use App\Contracts\Commands\User\IUserDeleteCommand;
use App\Contracts\Commands\User\IUserGetCommand;
use App\Contracts\Commands\User\IUserListCommand;
use App\Contracts\Commands\User\IUserSetAvatarCommand;
use App\Contracts\Commands\User\IUserUpdateCommand;
use App\Contracts\Commands\Paginators\IUserPaginatorCommand;
use App\Contracts\Commands\Role\IRoleListCommand;
use App\Contracts\Helpers\ILogger;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\IPermissionRepository;
use App\Contracts\Repositories\IRoleRepository;
use App\Contracts\Services\IDocumentAccessService;
use App\Contracts\Services\IAssignPermissionToRoleService;
use App\Contracts\Services\IAuthorizeService;
use App\Contracts\Services\IDocumentCreateAccessService;
use App\Contracts\Services\IPermissionService;
use App\Contracts\Services\ITemplateUpdateService;
use App\Contracts\Services\IUserCreateService;
use App\Contracts\Services\IUserUpdateService;
use App\Helpers\Logger;
use App\Packages\ImportExport\Services\ADocumentExportService;
use App\Packages\ImportExport\Services\DocumentExportFromBladeService;
use App\Repositories\AttributeRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Services\DocumentAccessService;
use App\Services\DocumentCreateAccessService;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\AssignPermissionToRoleService;
use App\Services\AuthorizeService;
use App\Services\DocumentCompareService;
use App\Services\DocumentGetService;
use App\Services\DocumentViewService;
use App\Services\PermissionService;
use App\Services\TemplateUpdateService;
use App\Services\UserCreateService;
use App\Services\UserUpdateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Invokers
        $this->app->bind(ITransactionCommandInvoker::class, TransactionCommandInvoker::class);
        $this->app->bind(IAtomCommandInvoker::class, AtomCommandInvoker::class);

        //Services
        $this->app->bind(IUserCreateService::class, UserCreateService::class);
        $this->app->bind(IUserUpdateService::class, UserUpdateService::class);
        $this->app->bind(ITemplateUpdateService::class, TemplateUpdateService::class);
        $this->app->bind(ADocumentCompareService::class, DocumentCompareService::class);
        $this->app->bind(ADocumentViewService::class, DocumentViewService::class);
        $this->app->bind(ADocumentGetService::class, DocumentGetService::class);
        $this->app->bind(ADocumentExportService::class, DocumentExportFromBladeService::class);
        $this->app->bind(IAuthorizeService::class, AuthorizeService::class);
        $this->app->bind(IPermissionService::class, PermissionService::class);
        $this->app->bind(IDocumentCreateAccessService::class, DocumentCreateAccessService::class);
        $this->app->bind(IDocumentAccessService::class, DocumentAccessService::class);

        //Commands
        $this->app->bind(IUserCreateCommand::class, UserCreateCommand::class);
        $this->app->bind(IUserSetAvatarCommand::class, UserSetAvatarCommand::class);
        $this->app->bind(IUserUpdateCommand::class, UserUpdateCommand::class);
        $this->app->bind(IUserGetCommand::class, UserGetCommand::class);
        $this->app->bind(IUserDeleteCommand::class, UserDeleteCommand::class);
        $this->app->bind(IUserListCommand::class, UserListCommand::class);

        $this->app->bind(IUserPaginatorCommand::class, UserPaginatorCommand::class);
        $this->app->bind(IRoleListCommand::class, RoleListCommand::class);
        $this->app->bind(IFactoryListCommand::class, FactoryListCommand::class);

        $this->app->bind(IDocumentPaginatorCommand::class, DocumentPaginatorCommand::class);
        $this->app->bind(IDocumentDeleteCommand::class, DocumentDeleteCommand::class);
        $this->app->bind(IDocumentGetCommand::class, DocumentGetCommand::class);
        $this->app->bind(IDocumentsDeleteCommand::class, DocumentsDeleteCommand::class);

        $this->app->bind(ITemplateListCommand::class, TemplateListCommand::class);
        $this->app->bind(ITagListCommand::class, TagListCommand::class);
        $this->app->bind(ILabelListCommand::class, LabelListCommand::class);

        $this->app->bind(IDocumentVersionGetCommand::class, DocumentVersionGetCommand::class);
        $this->app->bind(IDocumentVersionDeleteCommand::class, DocumentVersionDeleteCommand::class);

        $this->app->bind(ITemplatePaginatorCommand::class, TemplatePaginatorCommand::class);
        $this->app->bind(ITemplateGetCommand::class, TemplateGetCommand::class);
        $this->app->bind(ITemplateDeleteCommand::class, TemplateDeleteCommand::class);
        $this->app->bind(ITemplateCreateCommand::class, TemplateCreateCommand::class);
        $this->app->bind(ITemplateUpdateCommand::class, TemplateUpdateCommand::class);


        $this->app->bind(ILabelPaginatorCommand::class, LabelPaginatorCommand::class);
        $this->app->bind(ILabelCreateCommand::class, LabelCreateCommand::class);
        $this->app->bind(ILabelGetCommand::class, LabelGetCommand::class);
        $this->app->bind(ILabelUpdateCommand::class, LabelUpdateCommand::class);
        $this->app->bind(ILabelDeleteCommand::class, LabelDeleteCommand::class);

        $this->app->bind(ITypeListCommand::class, TypeListCommand::class);

        //Adapters
        $this->app->bind(ITableAdapter::class, TableAdapter::class);

        //Repositories
        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);
        $this->app->bind(IPermissionRepository::class, PermissionRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);

        $this->app->bind(ILogger::class, Logger::class);



        $this->app->bind(IRolePaginatorCommand::class, RolePaginatorCommand::class);
        $this->app->bind(IRoleCreateCommand::class, RoleCreateCommand::class);
        $this->app->bind(IRoleGetCommand::class, RoleGetCommand::class);
        $this->app->bind(IRoleUpdateCommand::class, RoleUpdateCommand::class);
        $this->app->bind(IRoleDeleteCommand::class, RoleDeleteCommand::class);

        $this->app->bind(IAssignPermissionToRoleService::class, AssignPermissionToRoleService::class);
    }
}
