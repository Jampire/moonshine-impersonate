<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jampire\MoonshineImpersonate\Events\ImpersonationEntered;
use Jampire\MoonshineImpersonate\Models\ImpersonatedAudit;
use MoonShine\MoonShineUI;

/**
 * Class AuditImpersonationEnter
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class AuditImpersonationEnter implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ImpersonationEntered $event): void
    {
        /** @var ImpersonatedAudit $userAudit */
        $userAudit = $event->impersonated->impersonatedAudit;
        if ($userAudit === null) {
            $event->impersonated->impersonatedAudit()->create([
                'moonshine_user_id' => $event->impersonator->getAuthIdentifier(),
                'counter' => 1,
            ]);

            return;
        }

        $userAudit->increment(column: 'counter', extra: [
            'moonshine_user_id' => $event->impersonator->getAuthIdentifier(),
        ]);
    }

    public function shouldQueue(ImpersonationEntered $event): bool
    {
        return method_exists($event->impersonated, 'impersonatedAudit');
    }

    public function failed(ImpersonationEntered $event, \Throwable $exception): void
    {
        logs()->error(sprintf('Failed to execute [%s] job.', get_class($this)), [
            'message' => $exception->getMessage(),
            'previous_impersonator' => $event->impersonator->getAuthIdentifier(),
            'previous_counter' => $event->impersonated->impersonatedAudit->counter,
        ]);

        MoonShineUI::toast(trans_impersonate('exceptions.audit_impersonated_failed'), 'error');
    }
}
