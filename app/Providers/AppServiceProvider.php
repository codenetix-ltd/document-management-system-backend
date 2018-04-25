<?php

namespace App\Providers;

use App\Adapters\TableAdapter;
use App\Attribute;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\IDocumentRepository;
use App\Contracts\Repositories\IDocumentVersionRepository;
use App\Contracts\Repositories\IFileRepository;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileCreateService;
use App\Contracts\Services\File\IFileManager;
use App\Contracts\Services\ITransaction;
use App\Contracts\System\ITransformer;
use App\File;
use App\Repositories\AttributeRepository;
use App\Repositories\DBTransaction;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentVersionRepository;
use App\Repositories\FileRepository;
use App\Repositories\TagRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\DocumentCompareService;
use App\Services\DocumentGetService;
use App\Services\DocumentViewService;
use App\Services\File\FileCreateService;
use App\Services\File\FileManager;
use App\Services\System\Transformer;
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
        $this->app->bind(IUserRepository::class, UserRepository::class);

        $this->app->bind(IFileRepository::class, FileRepository::class);
        $this->app->bind(IFileManager::class, FileManager::class);
        $this->app->bind(IFileCreateService::class, FileCreateService::class);

        $this->app->bind(ITemplateRepository::class, TemplateRepository::class);

        $this->app->bind(ITagRepository::class, TagRepository::class);

        $this->app->bind(ITypeRepository::class, TypeRepository::class);

        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);

        $this->app->bind(IDocumentRepository::class, DocumentRepository::class);

        $this->app->bind(IDocumentVersionRepository::class, DocumentVersionRepository::class);

        $this->app->bind(ITransformer::class, Transformer::class);

//_____________________________________________________________________________________________________________________
        $this->app->bind(ADocumentCompareService::class, DocumentCompareService::class);
        $this->app->bind(ADocumentViewService::class, DocumentViewService::class);
        $this->app->bind(ADocumentGetService::class, DocumentGetService::class);
        //Adapters
        $this->app->bind(ITableAdapter::class, TableAdapter::class);
        //Repositories

        $this->app->bind(ITransaction::class, DBTransaction::class);
    }
}
