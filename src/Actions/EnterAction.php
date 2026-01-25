<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Actions;

use Jampire\MoonshineImpersonate\Actions\Contracts\Actionable;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;

/**
 * Class EnterAction
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final readonly class EnterAction implements Actionable
{
    public function __construct(
        private ImpersonateManager $manager,
    ) {
        //
    }

    /**
     * @param int $id ID of the impersonated user
     */
    public function execute(int $id, bool $shouldValidate = true): bool
    {
        $user = $this->manager->findUserById($id);

        if ($shouldValidate && !$this->manager->canEnter($user)) {
            return false;
        }

        $this->manager->saveAuthInSession($user);

        ImpersonationEntered::dispatch($this->manager->moonshineUser, $user);

        return true;
    }
}
