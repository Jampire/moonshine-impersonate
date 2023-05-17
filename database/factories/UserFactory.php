<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

/**
 * Class UserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class UserFactory extends TestbenchUserFactory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'remember_token' => Str::random(10),
        ];
    }
}
