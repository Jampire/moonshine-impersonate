<?php

namespace Jampire\MoonshineImpersonate\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Listeners\ClearImpersonatedCache;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationEnter;
use Jampire\MoonshineImpersonate\Listeners\LogImpersonationStopped;

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
            ClearImpersonatedCache::class,
        ],
        ImpersonationStopped::class => [
            LogImpersonationStopped::class,
        ],
    ];
}
