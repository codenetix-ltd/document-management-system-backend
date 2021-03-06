<?php

namespace App\Providers;

use App\Adapters\TableAdapter;
use App\Attribute;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\Models\IAttribute;
use App\Contracts\Models\IFile;
use App\Contracts\Models\ITableTypeColumn;
use App\Contracts\Models\ITableTypeRow;
use App\Contracts\Models\ITag;
use App\Contracts\Models\ITemplate;
use App\Contracts\Models\IType;
use App\Contracts\Models\IUser;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\IFileRepository;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\Attribute\IAttributeCreateService;
use App\Contracts\Services\Attribute\IAttributeDeleteService;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Contracts\Services\Attribute\IAttributeListService;
use App\Contracts\Services\Attribute\IAttributeTypeTableValidator;
use App\Contracts\Services\File\IFileCreateService;
use App\Contracts\Services\File\IFileManager;
use App\Contracts\Services\Tag\ITagCreateService;
use App\Contracts\Services\Tag\ITagDeleteService;
use App\Contracts\Services\Tag\ITagGetService;
use App\Contracts\Services\Tag\ITagListService;
use App\Contracts\Services\Tag\ITagUpdateService;
use App\Contracts\Services\Template\ITemplateCreateService;
use App\Contracts\Services\Template\ITemplateDeleteService;
use App\Contracts\Services\Template\ITemplateGetService;
use App\Contracts\Services\Template\ITemplateListService;
use App\Contracts\Services\Template\ITemplateUpdateService;
use App\Contracts\Services\Type\ITypeListService;
use App\Contracts\Services\User\IUserAvatarUpdateService;
use App\Contracts\Services\User\IUserCreateService;
use App\Contracts\Services\User\IUserDeleteService;
use App\Contracts\Services\User\IUserGetService;
use App\Contracts\Services\User\IUserListService;
use App\Contracts\Services\User\IUserUpdateService;
use App\Contracts\System\ITransformer;
use App\File;
use App\Repositories\AttributeRepository;
use App\Repositories\FileRepository;
use App\Repositories\TagRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\Attribute\AttributeCreateService;
use App\Services\Attribute\AttributeDeleteService;
use App\Services\Attribute\AttributeGetService;
use App\Services\Attribute\AttributeListService;
use App\Services\Attribute\AttributeTypeTableValidator;
use App\Services\DocumentCompareService;
use App\Services\DocumentGetService;
use App\Services\DocumentViewService;
use App\Services\File\FileCreateService;
use App\Services\File\FileManager;
use App\Services\System\Transformer;
use App\Services\Tag\TagCreateService;
use App\Services\Tag\TagDeleteService;
use App\Services\Tag\TagGetService;
use App\Services\Tag\TagListService;
use App\Services\Tag\TagUpdateService;
use App\Services\Template\TemplateCreateService;
use App\Services\Template\TemplateDeleteService;
use App\Services\Template\TemplateGetService;
use App\Services\Template\TemplateListService;
use App\Services\Template\TemplateUpdateService;
use App\Services\Type\TypeListService;
use App\Services\User\UserAvatarUpdateService;
use App\Services\User\UserCreateService;
use App\Services\User\UserDeleteService;
use App\Services\User\UserGetService;
use App\Services\User\UserListService;
use App\Services\User\UserUpdateService;
use App\TableTypeColumn;
use App\TableTypeRow;
use App\Tag;
use App\Template;
use App\Type;
use App\User;
use Illuminate\Http\Resources\Json\Resource;
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
        Resource::withoutWrapping();
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


        $this->app->bind(ITemplate::class, Template::class);
        $this->app->bind(ITemplateRepository::class, TemplateRepository::class);
        $this->app->bind(ITemplateCreateService::class, TemplateCreateService::class);
        $this->app->bind(ITemplateGetService::class, TemplateGetService::class);
        $this->app->bind(ITemplateUpdateService::class, TemplateUpdateService::class);
        $this->app->bind(ITemplateDeleteService::class, TemplateDeleteService::class);
        $this->app->bind(ITemplateListService::class, TemplateListService::class);


        $this->app->bind(ITag::class, Tag::class);
        $this->app->bind(ITagRepository::class, TagRepository::class);
        $this->app->bind(ITagCreateService::class, TagCreateService::class);
        $this->app->bind(ITagGetService::class, TagGetService::class);
        $this->app->bind(ITagUpdateService::class, TagUpdateService::class);
        $this->app->bind(ITagDeleteService::class, TagDeleteService::class);
        $this->app->bind(ITagListService::class, TagListService::class);


        $this->app->bind(IType::class, Type::class);
        $this->app->bind(ITypeRepository::class, TypeRepository::class);
        $this->app->bind(ITypeListService::class, TypeListService::class);


        $this->app->bind(IAttribute::class, Attribute::class);
        $this->app->bind(ITableTypeRow::class, TableTypeRow::class);
        $this->app->bind(ITableTypeColumn::class, TableTypeColumn::class);
        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);
        $this->app->bind(IAttributeCreateService::class, AttributeCreateService::class);
        $this->app->bind(IAttributeGetService::class, AttributeGetService::class);
        $this->app->bind(IAttributeTypeTableValidator::class, AttributeTypeTableValidator::class);
        $this->app->bind(IAttributeDeleteService::class, AttributeDeleteService::class);
        $this->app->bind(IAttributeListService::class, AttributeListService::class);


        $this->app->bind(ITransformer::class, Transformer::class);

//_____________________________________________________________________________________________________________________
        $this->app->bind(ADocumentCompareService::class, DocumentCompareService::class);
        $this->app->bind(ADocumentViewService::class, DocumentViewService::class);
        $this->app->bind(ADocumentGetService::class, DocumentGetService::class);
        //Adapters
        $this->app->bind(ITableAdapter::class, TableAdapter::class);
        //Repositories
    }
}
