<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UpdatePermissionNameEvent' => [
            'App\Listeners\UpdatePermissionNameListener',
        ],
        'App\Events\UpdateWordNameEvent' => [
            'App\Listeners\UpdateWordListener',
        ],
        'App\Events\UpdateLangEvent' => [
            'App\Listeners\UpdateLangListener',
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
}
