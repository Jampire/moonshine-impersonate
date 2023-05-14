<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;

/**
 * Class CanBeImpersonated
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class CanBeImpersonated implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $manager = app(ImpersonateManager::class);
        $user = $manager->findUserById($value);

        if (!$manager->canBeImpersonated($user)) {
            $fail('ms-impersonate::validation.enter.cannot_be_impersonated')->translate();
        }
    }
}
