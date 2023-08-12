<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Jampire\MoonshineImpersonate\Models\ImpersonatedAudit;

/**
 * Trait HasImpersonatedAudit
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
trait HasImpersonatedAudit
{
    public function impersonatedAudit(): HasOne
    {
        return $this->hasOne(ImpersonatedAudit::class);
    }
}
