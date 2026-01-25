<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jampire\MoonshineImpersonate\ImpersonateServiceProvider;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use InteractsWithViews;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->artisan('migrate', ['--database' => 'testing'])->run();

        config(['auth.providers.users.model' => User::class]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            ImpersonateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        include_once __DIR__.'/Stubs/Database/Migrations/create_moonshine_users_table.php';
        include_once __DIR__.'/Stubs/Database/Migrations/create_moonshine_change_logs_table.php';

        /** @phpstan-ignore-next-line */
        (new \CreateMoonShineUsersTable())->up();
        /** @phpstan-ignore-next-line */
        (new \CreateMoonShineChangeLogsTable())->up();
    }
}
