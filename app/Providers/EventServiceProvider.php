<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener'
        ],
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

    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
        'App\Listeners\TemplateEventSubscriber',
        'App\Listeners\DocumentEventSubscriber',
        'App\Listeners\LabelEventSubscriber'
    ];
}
