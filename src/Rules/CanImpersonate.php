<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;

/**
 * Class CanImpersonate
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class CanImpersonate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);

        if (!$manager->canImpersonate()) {
            $fail('ms-impersonate::validation.enter.cannot_impersonate')->translate();
        }
    }
}
