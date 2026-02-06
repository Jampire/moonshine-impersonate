<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Jampire\MoonshineImpersonate\Tests\Stubs\Models\User;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

/**
 * Class UserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @extends TestbenchUserFactory<User>
 */
final class UserFactory extends TestbenchUserFactory
{
    protected $model = User::class;

    public function notImpersonated(): self
    {
        return $this->state(fn (): array => [
            'name' => fake()->name().' - Non-Impersonable',
        ]);
    }
}
