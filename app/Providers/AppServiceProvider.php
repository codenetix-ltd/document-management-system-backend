<?php

namespace App\Providers;

use App\Contracts\Helpers\ILogger;
use App\Contracts\Repositories\IFileRepository;
use App\Repositories\FileRepository;
use App\Services\LogService;
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
        $this->app->bind(IFileRepository::class, FileRepository::class);
        $this->app->bind(ILogger::class, LogService::class);
    }
}
