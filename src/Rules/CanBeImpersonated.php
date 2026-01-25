<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class CanBeImpersonated
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class CanBeImpersonated implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);
        $user = $manager->findUserById($value);

        if (!$manager->canBeImpersonated($user)) {
            $fail(Settings::ALIAS.'::validation.enter.cannot_be_impersonated')->translate();
        }
    }
}
