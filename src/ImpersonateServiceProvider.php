<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate;

use Illuminate\Support\ServiceProvider;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class ImpersonateServiceProvider
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ImpersonateManager::class,
            fn () => new ImpersonateManager(auth(Settings::moonShineGuard())->user())
        );

        $this->mergeConfigFrom(__DIR__.'/../config/ms-impersonate.php', 'ms-impersonate');
    }

    public function boot(): void
    {
        $this->publishConfig();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'ms-impersonate');
    }

    private function publishConfig(): void
    {
        if (!$this->app->runningInConsole()) {
            // @codeCoverageIgnoreStart
            return;
            // @codeCoverageIgnoreEnd
        }

        $this->publishes(
            [
                __DIR__.'/../config/ms-impersonate.php' => config_path('ms-impersonate.php'),
            ],
            [
                'config',
            ]
        );
    }
}
