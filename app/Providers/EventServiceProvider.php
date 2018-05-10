<?php

namespace App\Providers;

use App\Listeners\DocumentEventSubscriber;
use App\Listeners\TagEventSubscriber;
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
        'App\Events\UserLogin' => [
            'App\Listeners\LogEventListener'
        ],
        'App\Events\UserLogout' => [
            'App\Listeners\LogEventListener'
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
        DocumentEventSubscriber::class,
        TagEventSubscriber::class,
        UserEventSubscriber::class,
        TemplateEventSubscriber::class,
    ];
}
