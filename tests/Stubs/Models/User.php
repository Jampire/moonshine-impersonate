<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories\UserFactory;
use MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * Class User
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class User extends BaseUser
{
    use HasFactory;
    use HasMoonShineChangeLog;

    protected $table = 'users';

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
