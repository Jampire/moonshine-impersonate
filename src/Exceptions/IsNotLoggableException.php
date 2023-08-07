<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Exceptions;

use Illuminate\Contracts\Auth\Authenticatable;
use MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * Class IsNotLoggableException
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class IsNotLoggableException extends \Exception
{
    public static function userIsNotLoggable(Authenticatable $impersonated): self
    {
        return new self(sprintf(
            'User model class %s does not use %s trait. Please read MoonShine documentation.',
            get_class($impersonated),
            HasMoonShineChangeLog::class,
        ));
    }
}
