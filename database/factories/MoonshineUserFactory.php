<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Database\Factories;

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

    public function definition(): array
    {
        return [
            'moonshine_user_role_id' => 1,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('secret'),
            'remember_token' => Str::random(10),
        ];
    }
}
