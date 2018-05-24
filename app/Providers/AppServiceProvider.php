<?php

namespace App\Providers;

use App\Adapters\TableAdapter;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\Helpers\ILogger;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\IAttributeValueRepository;
use App\Contracts\Repositories\IDocumentRepository;
use App\Contracts\Repositories\IDocumentVersionRepository;
use App\Contracts\Repositories\IFileRepository;
use App\Contracts\Repositories\IRoleRepository;
use App\Contracts\Repositories\ILogRepository;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Repositories\ITemplateRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\File\IFileCreateService;
use App\Contracts\Services\File\IFileManager;
use App\Contracts\Services\ITransaction;
use App\Contracts\System\ITransformer;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\DBTransaction;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentVersionRepository;
use App\Repositories\FileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\LogRepository;
use App\Repositories\TagRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Services\ADocumentCompareService;
use App\Services\ADocumentGetService;
use App\Services\ADocumentViewService;
use App\Services\Components\IEventDispatcher;
use App\Services\Components\LaravelEventDispatcher;
use App\Services\DocumentCompareService;
use App\Services\DocumentViewService;
use App\Services\File\FileCreateService;
use App\Services\File\FileManager;
use App\Services\PermissionService;
use App\Services\LogService;
use App\Services\System\Transformer;
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
//        $this->app->bind(IUserRepository::class, UserRepository::class);
//
        $this->app->bind(IFileRepository::class, FileRepository::class);
//        $this->app->bind(IFileManager::class, FileManager::class);
//        $this->app->bind(IFileCreateService::class, FileCreateService::class);
//
//        $this->app->bind(ITemplateRepository::class, TemplateRepository::class);
//
//        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);
//
//        $this->app->bind(IDocumentRepository::class, DocumentRepository::class);
//
//        $this->app->bind(IDocumentVersionRepository::class, DocumentVersionRepository::class);
//
//        $this->app->bind(IAttributeValueRepository::class, AttributeValueRepository::class);
//
//        $this->app->bind(ILogRepository::class, LogRepository::class);
//
//        $this->app->bind(ITransformer::class, Transformer::class);
//
//        $this->app->bind(IRoleRepository::class, RoleRepository::class);

//_____________________________________________________________________________________________________________________
//        $this->app->bind(ADocumentCompareService::class, DocumentCompareService::class);
//        $this->app->bind(ADocumentViewService::class, DocumentViewService::class);
//        $this->app->bind(ITableAdapter::class, TableAdapter::class);
//
//        $this->app->bind(ITransaction::class, DBTransaction::class);
//
        $this->app->bind(ILogger::class, LogService::class);
//        $this->app->bind(IEventDispatcher::class, LaravelEventDispatcher::class);
    }
}
