<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Jampire\MoonshineImpersonate\Actions\EnterAction;
use Jampire\MoonshineImpersonate\Actions\StopAction;
use Jampire\MoonshineImpersonate\Guards\SessionGuard;
use Jampire\MoonshineImpersonate\Http\Middleware\ImpersonateMiddleware;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\UI\View\Components\StopImpersonation;

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
            fn (): ImpersonateManager => new ImpersonateManager(auth(Settings::moonShineGuard())->user())
        );

        $this->app->bind(
            EnterAction::class,
            fn (): EnterAction => new EnterAction(app(ImpersonateManager::class))
        );

        $this->app->bind(
            StopAction::class,
            fn (): StopAction => new StopAction(app(ImpersonateManager::class))
        );

        $this->mergeConfigFrom(__DIR__.'/../config/'.Settings::ALIAS.'.php', Settings::ALIAS);

        $this->registerAuthDriver();
    }

    public function boot(Kernel $kernel): void
    {
        $this->registerMiddleware($kernel);

        $this->registerViews();

        $this->publishImpersonateResources();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../lang', Settings::ALIAS);
    }

    private function registerMiddleware(Kernel $kernel): void
    {
        app('router')->aliasMiddleware(Settings::ALIAS, ImpersonateMiddleware::class);

        foreach (config_impersonate('routes.middleware') as $group) {
            $kernel->appendMiddlewareToGroup($group, ImpersonateMiddleware::class);
        }
    }

    /**
     * @author lab404/laravel-impersonate
     * @return void
     */
    private function registerAuthDriver(): void
    {
        $auth = app('auth');

        $auth->extend('session', function (Application $app, $name, array $config) use ($auth) {
            $provider = $auth->createUserProvider($config['provider']);

            $guard = new SessionGuard($name, $provider, $app['session.store']);

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });
    }

    private function registerViews(): void
    {
        $this->loadViewComponentsAs(Settings::ALIAS, [
            'stop' => StopImpersonation::class,
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', Settings::ALIAS);

        if (config_impersonate('buttons.stop.enabled') === true) {
            config([
                'moonshine.header' => Settings::ALIAS . '::impersonate.buttons.stop',
            ]);
        }

        if ($this->app->runningUnitTests()) {
            $this->loadViewsFrom(__DIR__.'/../tests/Stubs/resources/views', 'moonshine');
        }
    }

    private function publishImpersonateResources(): void
    {
        if (!$this->app->runningInConsole()) {
            // @codeCoverageIgnoreStart
            return;
            // @codeCoverageIgnoreEnd
        }

        // Configuration
        $this->publishes(
            [
                __DIR__.'/../config/'.Settings::ALIAS.'.php' => config_path(Settings::ALIAS.'.php'),
            ],
            [
                Settings::ALIAS,
                'config',
            ]
        );

        // Localization
        $this->publishes(
            [
                __DIR__.'/../lang' => $this->app->langPath('vendor/'.Settings::ALIAS)
            ],
            [
                Settings::ALIAS,
                'lang',
            ]
        );

        // Views
        $this->publishes(
            [
                __DIR__.'/../resources/views/impersonate' => resource_path('views/vendor/impersonate')
            ],
            [
                Settings::ALIAS,
                'views',
            ]
        );

        // Views Components
        $this->publishes(
            [
                __DIR__.'/../src/UI/View/Components' => app_path('View/Components'),
                __DIR__.'/../resources/views/components' => resource_path('views/components'),
            ],
            [
                Settings::ALIAS,
                'view-components',
            ]
        );
    }
}
