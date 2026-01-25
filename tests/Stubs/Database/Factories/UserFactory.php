<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

/**
 * Class UserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @extends TestbenchUserFactory<User>
 */
class UserFactory extends TestbenchUserFactory
{
    protected $model = User::class;

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

    public function notImpersonated(): self
    {
        return $this->state(fn (): array => [
            'name' => fake()->name().' - Non-Impersonable',
        ]);
    }
}
