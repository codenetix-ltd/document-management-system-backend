<?php

namespace App\Providers;

use App\Repositories\AttributeRepository;
use App\Repositories\AttributeRepositoryEloquent;
use App\Repositories\DocumentRepository;
use App\Repositories\DocumentRepositoryEloquent;
use App\Repositories\LabelRepository;
use App\Repositories\LabelRepositoryEloquent;
use App\Repositories\PermissionGroupRepository;
use App\Repositories\PermissionGroupRepositoryEloquent;
use App\Repositories\RoleRepository;
use App\Repositories\RoleRepositoryEloquent;
use App\Repositories\TemplateRepository;
use App\Repositories\TemplateRepositoryEloquent;
use App\Repositories\TypeRepository;
use App\Repositories\TypeRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TemplateRepository::class, TemplateRepositoryEloquent::class);
        $this->app->bind(LabelRepository::class, LabelRepositoryEloquent::class);
        $this->app->bind(TypeRepository::class, TypeRepositoryEloquent::class);
        $this->app->bind(PermissionGroupRepository::class, PermissionGroupRepositoryEloquent::class);
        $this->app->bind(RoleRepository::class, RoleRepositoryEloquent::class);
        $this->app->bind(AttributeRepository::class, AttributeRepositoryEloquent::class);
        $this->app->bind(DocumentRepository::class, DocumentRepositoryEloquent::class);
    }
}
