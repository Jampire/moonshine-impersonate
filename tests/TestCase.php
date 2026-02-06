<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jampire\MoonshineImpersonate\ImpersonateServiceProvider;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use MoonShine\ChangeLog\ChangeLogServiceProvider;
use MoonShine\Laravel\Providers\MoonShineServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use InteractsWithViews;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
    }

    #[\Override]
    protected function getPackageProviders($app): array
    {
        return [
            MoonShineServiceProvider::class,
            ChangeLogServiceProvider::class,
            ImpersonateServiceProvider::class,
        ];
    }

    #[\Override]
    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config): void {
            $config->set('auth.providers.users.model', User::class);
            $config->set('moonshine.auth.model', MoonshineUser::class);
            $config->set('moonshine.prefix', 'admin');
        });
    }
}
