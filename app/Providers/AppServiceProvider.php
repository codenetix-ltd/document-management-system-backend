<?php

namespace App\Providers;

use App\Contracts\Helpers\ILogger;
use App\Http\Requests\ABaseAPIRequest;
use App\Services\AuthPermissions;
use App\Services\LogService;
use Illuminate\Foundation\Http\FormRequest;
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

        $this->app->resolving(ABaseAPIRequest::class, function ($request, $app) {
            $request = ABaseAPIRequest::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }
}
