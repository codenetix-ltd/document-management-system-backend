<?php

namespace App\Providers;

use App\Listeners\DocumentEventSubscriber;
use App\Listeners\LabelEventSubscriber;
use App\Listeners\TemplateEventSubscriber;
use App\Listeners\UserEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * @var array
     */
    protected $subscribe = [
        DocumentEventSubscriber::class,
        LabelEventSubscriber::class,
        UserEventSubscriber::class,
        TemplateEventSubscriber::class,
    ];
}
