<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Actions;

use Illuminate\Support\Facades\Auth;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class EnterAction
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class EnterAction
{
    public function __construct(
        private ImpersonateManager $manager
    ) {
        //
    }

    public function execute(int $id): bool
    {
        $user = $this->manager->findUserById($id);

        if ($user === null) {
            return false;
        }

        $this->manager->saveAuthInSession($user);

        Auth::guard(Settings::defaultGuard())->logout();
        Auth::guard(Settings::defaultGuard())->setUser($user);
        // Auth::onceUsingId($user->id);

        ImpersonationEntered::dispatch($this->manager->moonshineUser, $user);

        return true;
    }
}
