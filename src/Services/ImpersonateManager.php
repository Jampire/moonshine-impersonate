<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Jampire\MoonshineImpersonate\Services\Contracts\BeImpersonable;
use Jampire\MoonshineImpersonate\Services\Contracts\Impersonable;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class ImpersonateManager
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class ImpersonateManager
{
    private ?Authenticatable $user = null;

    public function __construct(
        public readonly Authenticatable $moonshineUser,
    ) {
        //
    }

    public function findUserById(int $id): Authenticatable
    {
        if ($this->user instanceof Authenticatable && $this->user->getAuthIdentifier() === $id) {
            return $this->user;
        }

        $userModel = Settings::userClass(); // TODO: implement 'database' provider
        $this->user = $userModel::query()->findOrFail($id);

        return $this->user;
    }

    public function getUserFromSession(): ?Authenticatable
    {
        // @codeCoverageIgnoreStart
        try {
            $id = session()->get(Settings::key());
        } catch (\Throwable) {
            return null;
        }
        // @codeCoverageIgnoreEnd

        return $id === null ? null : $this->findUserById($id);
    }

    public function canEnter(Authenticatable $userToImpersonate): bool
    {
        if ($this->isImpersonating()) {
            return false;
        }

        if (!$this->canImpersonate()) {
            return false;
        }

        return $this->canBeImpersonated($userToImpersonate);
    }

    public function canStop(): bool
    {
        if (!$this->isImpersonating()) {
            return false;
        }

        return $this->canImpersonate();
    }

    public function isImpersonating(): bool
    {
        return session()->has(Settings::key());
    }

    public function canImpersonate(): bool
    {
        return !$this->moonshineUser instanceof Impersonable || $this->moonshineUser->canImpersonate();
    }

    public function canBeImpersonated(Authenticatable $userToImpersonate): bool
    {
        return !$userToImpersonate instanceof BeImpersonable || $userToImpersonate->canBeImpersonated();
    }

    public function saveAuthInSession(Authenticatable $user): void
    {
        session([
            Settings::key() => $user->getAuthIdentifier(),
            Settings::impersonatorSessionKey() => $this->moonshineUser->getAuthIdentifier(),
            Settings::impersonatorSessionGuardKey() => Settings::moonShineGuard(),
        ]);
    }

    public function clearAuthFromSession(): void
    {
        session()->forget([
            Settings::key(),
            Settings::impersonatorSessionKey(),
            Settings::impersonatorSessionGuardKey(),
        ]);
    }
}
