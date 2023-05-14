<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;

/**
 * Class IsNotImpersonating
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class IsNotImpersonating implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);

        if ($manager->isImpersonating()) {
            $fail('ms-impersonate::validation.enter.is_impersonating')->translate();
        }
    }
}
