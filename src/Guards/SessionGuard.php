<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Guards;

use Illuminate\Auth\SessionGuard as BaseSessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class SessionGuard
 *
 * @author lab404/laravel-impersonate
 */
final class SessionGuard extends BaseSessionGuard
{
    /**
     * Log a user into the application without firing the Login event.
     */
    public function quietLogin(Authenticatable $user): void
    {
        $this->updateSession($user->getAuthIdentifier());
        $this->setUser($user);
    }
    /**
     * Logout the user without updating remember_token
     * and without firing the Logout event.
     */
    public function quietLogout(): void
    {
        $this->clearUserDataFromStorage();
        $this->user = null;
        $this->loggedOut = true;
    }
}
