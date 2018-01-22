<?php

namespace App\Providers;

use App\Contracts\Services\IMorphMapService;
use App\Services\MorphMapService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class MorphMapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap(config('system.morphMap'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IMorphMapService::class, MorphMapService::class);
    }
}
