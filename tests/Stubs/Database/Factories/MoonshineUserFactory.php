<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;

/**
 * Class MoonshineUserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class MoonshineUserFactory extends Factory
{
    protected $model = MoonshineUser::class;

    /**
     * @return array{moonshine_user_role_id: int, name: string, email: string, password: string, remember_token: string}
     */
    public function definition(): array
    {
        return [
            'moonshine_user_role_id' => 1,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('secret'),
            'remember_token' => Str::random(10),
        ];
    }

    public function cannotImpersonate(): self
    {
        return $this->state(fn (): array => [
            'moonshine_user_role_id' => 2,
        ]);
    }
}
