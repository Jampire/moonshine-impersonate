<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ImpersonationStopped
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
final class ImpersonationStopped
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public readonly Authenticatable $impersonator,
        public readonly Authenticatable $impersonated,
    ) {
        //
    }
}
