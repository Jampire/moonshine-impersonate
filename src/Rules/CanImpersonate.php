<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class CanImpersonate
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class CanImpersonate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);

        if (!$manager->canImpersonate()) {
            $fail(Settings::ALIAS.'::validation.enter.cannot_impersonate')->translate();
        }
    }
}
