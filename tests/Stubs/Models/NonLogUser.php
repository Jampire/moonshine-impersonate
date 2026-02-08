<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories\NonLogUserFactory;

/**
 * Class NonLogUser
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class NonLogUser extends BaseUser
{
    use HasFactory;

    protected $table = 'users';

    protected static function newFactory(): NonLogUserFactory
    {
        return NonLogUserFactory::new();
    }
}
