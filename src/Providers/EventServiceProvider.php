<?php

namespace Jampire\MoonshineImpersonate\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationEnter;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationStopped;
use Jampire\MoonshineImpersonate\Observers\ClearImpersonatedCacheObserver;
use MoonShine\Models\MoonshineChangeLog;

/**
 * Class EventServiceProvider
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ImpersonationEntered::class => [
            LogImpersonationEnter::class,
        ],
        ImpersonationStopped::class => [
            LogImpersonationStopped::class,
        ],
    ];

    protected $observers = [
        MoonshineChangeLog::class => [
            ClearImpersonatedCacheObserver::class,
        ],
    ];
}
