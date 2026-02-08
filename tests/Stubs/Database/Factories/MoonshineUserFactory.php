<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jampire\MoonshineImpersonate\Tests\Stubs\Models\MoonshineUser;
use MoonShine\Laravel\Database\Factories\MoonshineUserFactory as BaseFactory;

/**
 * Class MoonshineUserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @extends Factory<MoonshineUser>
 */
final class MoonshineUserFactory extends BaseFactory
{
    protected $model = MoonshineUser::class;

    public function cannotImpersonate(): self
    {
        return $this->state(fn (): array => [
            'moonshine_user_role_id' => 2,
        ]);
    }
}
