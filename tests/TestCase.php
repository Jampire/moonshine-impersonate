<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jampire\MoonshineImpersonate\ImpersonateServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ImpersonateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        include_once __DIR__.'/../database/migrations/create_moonshine_users_table.php';

        (new \CreateMoonShineUsersTable())->up();
    }
}
