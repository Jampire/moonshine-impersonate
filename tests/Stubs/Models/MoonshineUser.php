<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Tests\Stubs\Models;

use Jampire\MoonshineImpersonate\Services\Contracts\Impersonable;
use Jampire\MoonshineImpersonate\Tests\Stubs\Database\Factories\MoonshineUserFactory;
use MoonShine\Models\MoonshineUser as BaseUser;

/**
 * Class User
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class MoonshineUser extends BaseUser implements Impersonable
{
    protected $table = 'moonshine_users';

    protected static function newFactory(): MoonshineUserFactory
    {
        return MoonshineUserFactory::new();
    }

    public function canImpersonate(): bool
    {
        return $this->moonshine_user_role_id === 1;
    }
}
