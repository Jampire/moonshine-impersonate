<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\NonLogUser;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

/**
 * Class NonLogUserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class NonLogUserFactory extends TestbenchUserFactory
{
    protected $model = NonLogUser::class;

    /**
     * @return array{name: string, email: string, email_verified_at: \Illuminate\Support\Carbon, password: string, remember_token: string}
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'remember_token' => Str::random(10),
        ];
    }
}
