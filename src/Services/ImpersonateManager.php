<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Illuminate\Contracts\Auth\Authenticatable;
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
        if ($this->user !== null && $this->user->getAuthIdentifier() === $id) {
            return $this->user;
        }

        $userModel = Settings::userClass(); // TODO: if provider is 'database' ?
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

        // @codeCoverageIgnoreStart
        if (!$this->canImpersonate()) {
            return false;
        }
        // @codeCoverageIgnoreEnd

        return ! (!$this->canBeImpersonated($userToImpersonate));
    }

    public function canStop(): bool
    {
        if (!$this->isImpersonating()) {
            return false;
        }

        return ! (!$this->canImpersonate());
    }

    public function isImpersonating(): bool
    {
        return session()->has(Settings::key());
    }

    public function canImpersonate(): bool
    {
        // TODO: implement Permission::IMPERSONATE permission

        return true;
    }

    public function canBeImpersonated(Authenticatable $userToImpersonate): bool
    {
        // TODO: implement which users are allowed to be impersonated

        return $userToImpersonate->getAuthIdentifier() > 0;
    }

    public function saveAuthInSession(Authenticatable $user): void
    {
        session([
            config_impersonate('key') => $user->getAuthIdentifier(),
            Settings::impersonatorSessionKey() => $this->moonshineUser->getAuthIdentifier(),
            Settings::impersonatorSessionGuardKey() => Settings::moonShineGuard(),
        ]);
    }

    public function clearAuthFromSession(): void
    {
        session()->forget([
            config_impersonate('key'),
            Settings::impersonatorSessionKey(),
            Settings::impersonatorSessionGuardKey(),
        ]);
    }
}
