<?php

namespace App\Providers;

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
        $this->app->bind(\App\Repositories\TemplateRepository::class, \App\Repositories\TemplateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\LabelRepository::class, \App\Repositories\LabelRepositoryEloquent::class);

    }
}
