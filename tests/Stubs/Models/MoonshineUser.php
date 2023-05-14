<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Models;

use Jampire\MoonshineImpersonate\Database\Factories\MoonshineUserFactory;
use MoonShine\Models\MoonshineUser as BaseUser;

/**
 * Class User
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class MoonshineUser extends BaseUser
{
    protected $table = 'moonshine_users';

    protected static function newFactory(): MoonshineUserFactory
    {
        return MoonshineUserFactory::new();
    }
}
