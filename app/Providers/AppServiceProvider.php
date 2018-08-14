<?php

namespace App\Providers;

use App\Contracts\Helpers\ILogger;
use App\Entities\Document;
use App\Services\AuthPermissions;
use App\Services\Comments\CommentTransformer;
use App\Services\Comments\ITransformer;
use App\Services\LogService;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $this->app->bind(ILogger::class, LogService::class);
        $this->app->bind('AuthPermissions', AuthPermissions::class);
        $this->app->bind(ITransformer::class, CommentTransformer::class);
    }
}
