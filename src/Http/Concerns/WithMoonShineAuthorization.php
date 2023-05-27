<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Http\Concerns;

use MoonShine\MoonShineAuth;

/**
 * Trait WithMoonShineAuthorization
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
trait WithMoonShineAuthorization
{
    public function authorize(): bool
    {
        return MoonShineAuth::guard()->check();
    }
}
