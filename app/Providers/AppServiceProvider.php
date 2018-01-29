<?php

namespace App\Providers;

use App\Adapters\TableAdapter;
use App\Commands\Document\DocumentDeleteCommand;
use App\Commands\Document\DocumentGetCommand;
use App\Commands\Document\DocumentsDeleteCommand;
use App\Commands\DocumentVersion\DocumentVersionDeleteCommand;
use App\Commands\DocumentVersion\DocumentVersionGetCommand;
use App\Commands\Paginators\DocumentPaginatorCommand;
use App\Commands\Paginators\LabelPaginatorCommand;
use App\Commands\Paginators\TemplatePaginatorCommand;
use App\Commands\Paginators\UserPaginatorCommand;
use App\Commands\Tag\TagListCommand;
use App\Commands\Template\TemplateCreateCommand;
use App\Commands\Template\TemplateDeleteCommand;
use App\Commands\Template\TemplateGetCommand;
use App\Commands\Template\TemplateListCommand;
use App\Commands\Template\TemplateUpdateCommand;
use App\Commands\Type\TypeListCommand;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\Commands\Document\IDocumentDeleteCommand;
use App\Contracts\Commands\Document\IDocumentGetCommand;
use App\Contracts\Commands\Document\IDocumentsDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionDeleteCommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionGetCommand;
use App\Contracts\Commands\Paginators\IDocumentPaginatorCommand;
use App\Contracts\Commands\Paginators\ILabelPaginatorCommand;
use App\Contracts\Commands\Paginators\ITemplatePaginatorCommand;
use App\Contracts\Commands\Tag\ITagListCommand;
use App\Contracts\Commands\Template\ITemplateCreateCommand;
use App\Contracts\Commands\Template\ITemplateDeleteCommand;
use App\Contracts\Commands\Template\ITemplateGetCommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Commands\Template\ITemplateUpdateCommand;
use App\Contracts\Commands\Type\ITypeListCommand;
use App\Contracts\Commands\Paginators\IUserPaginatorCommand;
use App\Contracts\Models\IFile;
use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\IFileRepository;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileCreateService;
use App\Contracts\Services\File\IFileManager;
use App\Contracts\Services\ITemplateUpdateService;
use App\Contracts\Services\User\IUserAvatarUpdateService;
use App\Contracts\Services\User\IUserCreateService;
use App\Contracts\Services\User\IUserDeleteService;
use App\Contracts\Services\User\IUserGetService;
use App\Contracts\Services\User\IUserListService;
use App\Contracts\Services\User\IUserUpdateService;
use App\File;
use App\Repositories\AttributeRepository;
use App\Repositories\FileRepository;
use App\Repositories\UserRepository;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\DocumentCompareService;
use App\Services\DocumentGetService;
use App\Services\DocumentViewService;
use App\Services\File\FileCreateService;
use App\Services\File\FileManager;
use App\Services\TemplateUpdateService;
use App\Services\User\UserAvatarUpdateService;
use App\Services\User\UserCreateService;
use App\Services\User\UserDeleteService;
use App\Services\User\UserGetService;
use App\Services\User\UserListService;
use App\Services\User\UserUpdateService;
use App\User;
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
        $this->app->bind(IUser::class, User::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserCreateService::class, UserCreateService::class);
        $this->app->bind(IUserAvatarUpdateService::class, UserAvatarUpdateService::class);
        $this->app->bind(IUserUpdateService::class, UserUpdateService::class);
        $this->app->bind(IUserDeleteService::class, UserDeleteService::class);
        $this->app->bind(IUserGetService::class, UserGetService::class);
        $this->app->bind(IUserListService::class, UserListService::class);


        $this->app->bind(IFile::class, File::class);
        $this->app->bind(IFileRepository::class, FileRepository::class);
        $this->app->bind(IFileManager::class, FileManager::class);
        $this->app->bind(IFileCreateService::class, FileCreateService::class);


//_____________________________________________________________________________________________________________________
        $this->app->bind(ITemplateUpdateService::class, TemplateUpdateService::class);
        $this->app->bind(ADocumentCompareService::class, DocumentCompareService::class);
        $this->app->bind(ADocumentViewService::class, DocumentViewService::class);
        $this->app->bind(ADocumentGetService::class, DocumentGetService::class);
        $this->app->bind(IUserPaginatorCommand::class, UserPaginatorCommand::class);
        $this->app->bind(IDocumentPaginatorCommand::class, DocumentPaginatorCommand::class);
        $this->app->bind(IDocumentDeleteCommand::class, DocumentDeleteCommand::class);
        $this->app->bind(IDocumentGetCommand::class, DocumentGetCommand::class);
        $this->app->bind(IDocumentsDeleteCommand::class, DocumentsDeleteCommand::class);
        $this->app->bind(ITemplateListCommand::class, TemplateListCommand::class);
        $this->app->bind(ITagListCommand::class, TagListCommand::class);
        $this->app->bind(IDocumentVersionGetCommand::class, DocumentVersionGetCommand::class);
        $this->app->bind(IDocumentVersionDeleteCommand::class, DocumentVersionDeleteCommand::class);
        $this->app->bind(ITemplatePaginatorCommand::class, TemplatePaginatorCommand::class);
        $this->app->bind(ITemplateGetCommand::class, TemplateGetCommand::class);
        $this->app->bind(ITemplateDeleteCommand::class, TemplateDeleteCommand::class);
        $this->app->bind(ITemplateCreateCommand::class, TemplateCreateCommand::class);
        $this->app->bind(ITemplateUpdateCommand::class, TemplateUpdateCommand::class);
        $this->app->bind(ILabelPaginatorCommand::class, LabelPaginatorCommand::class);
        $this->app->bind(ITypeListCommand::class, TypeListCommand::class);
        //Adapters
        $this->app->bind(ITableAdapter::class, TableAdapter::class);
        //Repositories
        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);
    }
}
