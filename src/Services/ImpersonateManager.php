<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class ImpersonateManager
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class ImpersonateManager
{
    private Authenticatable|User|null $user = null;

    public function __construct(
        public readonly Authenticatable|User $moonshineUser,
    ) {
        //
    }

    public function findUserById(int $id): ?Authenticatable
    {
        if ($this->user !== null && $this->user->getKey() === $id) {
            return $this->user;
        }

        $userModel = Settings::userClass();
        $this->user = $userModel::query()->find($id);

        return $this->user;
    }

    public function getUserFromSession(): ?Authenticatable
    {
        // @codeCoverageIgnoreStart
        try {
            $id = session()->get(Settings::key());
        } catch (\Throwable $e) {
            return null;
        }
        // @codeCoverageIgnoreEnd

        return $id === null ? null : $this->findUserById($id);
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

    public function canBeImpersonated(Authenticatable|User $user = null): bool
    {
        // TODO: implement what users are allowed to be impersonated

        return $user !== null;
    }

    public function saveAuthInSession(Authenticatable|User $user): void
    {
        session([
            config('ms-impersonate.key') => $user->getKey(),
            Settings::impersonatorSessionKey() => $this->moonshineUser->getKey(),
            Settings::impersonatorSessionGuardKey() => Settings::moonShineGuard(),
        ]);
    }

    public function clearAuthFromSession(): void
    {
        session()->forget([
            config('ms-impersonate.key'),
            Settings::impersonatorSessionKey(),
            Settings::impersonatorSessionGuardKey(),
        ]);
    }
}
