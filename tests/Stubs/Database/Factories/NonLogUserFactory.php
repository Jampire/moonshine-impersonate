<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories;

use Jampire\MoonshineImpersonate\Tests\Stubs\Models\NonLogUser;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

/**
 * Class NonLogUserFactory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @extends TestbenchUserFactory<NonLogUser>
 */
final class NonLogUserFactory extends TestbenchUserFactory
{
    protected $model = NonLogUser::class;
}
