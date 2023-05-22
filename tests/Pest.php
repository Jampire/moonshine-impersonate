<?php

declare(strict_types=1);

use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Jampire\MoonshineImpersonate\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function enableMoonShineGuard(): void
{
    config([
        'moonshine.auth.enable' => true,
        'moonshine.auth.guard' => 'moonshine',
    ]);
}

function setAuthConfig(): void
{
    config([
        'auth' => [
            'defaults' => [
                'guard' => 'web',
                'passwords' => 'users',
            ],
            'guards' => [
                'web' => [
                    'driver' => 'session',
                    'provider' => 'users',
                ],
                'fake' => [
                    'driver' => 'session',
                    'provider' => 'users',
                ],
                'moonshine' => [
                    'driver' => 'session',
                    'provider' => 'moonshine',
                ],
            ],
            'providers' => [
                'users' => [
                    'driver' => 'eloquent',
                    'model' => User::class,
                ],
                'moonshine' => [
                    'driver' => 'eloquent',
                    'model' => MoonshineUser::class,
                ],
            ],
            'passwords' => [
                'users' => [
                    'provider' => 'users',
                    'table' => 'password_reset_tokens',
                    'expire' => 60,
                    'throttle' => 60,
                ],
            ],
            'password_timeout' => 10800,
        ],
    ]);
}
