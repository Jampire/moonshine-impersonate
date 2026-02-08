<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class IsNotImpersonating
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class IsNotImpersonating implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);

        if ($manager->isImpersonating()) {
            $fail(Settings::ALIAS.'::validation.enter.is_impersonating')->translate();
        }
    }
}
