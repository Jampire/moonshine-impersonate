<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class StopAction
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class StopAction
{
    public function __construct(
        private readonly ImpersonateManager $manager
    ) {
        //
    }

    public function execute(): bool
    {
        $user = $this->manager->getUserFromSession();
        if (!$user instanceof Authenticatable) {
            return false;
        }

        Auth::guard(Settings::defaultGuard())->quietLogout();
        $this->manager->clearAuthFromSession();

        ImpersonationStopped::dispatch($this->manager->moonshineUser, $user);

        return true;
    }
}
