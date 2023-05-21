<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Actions;

use Illuminate\Support\Facades\Auth;
use Jampire\MoonshineImpersonate\Events\ImpersonationStopped;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class StopAction
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class StopAction
{
    public function __construct(
        private ImpersonateManager $manager
    ) {
        //
    }

    public function execute(): bool
    {
        $user = $this->manager->getUserFromSession();
        if ($user === null) {
            return false;
        }

        Auth::guard(Settings::defaultGuard())->quietLogout();
        $this->manager->clearAuthFromSession();

        ImpersonationStopped::dispatch($this->manager->moonshineUser, $user);

        return true;
    }
}
