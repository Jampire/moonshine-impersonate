<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Exceptions\IsNotLoggableException;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * Class ImpersonatedAggregationService
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * TODO: set cache
 */
class ImpersonatedAggregationService
{
    public readonly Collection $logs;

    public function __construct(public readonly Authenticatable $impersonated)
    {
        throw_if(
            !Settings::isImpersonationLoggable(),
            new IsNotLoggableException(),
            trans_impersonate('ui.exceptions.impersonated_not_loggable', [
                'class' => get_class($this->impersonated),
                'trait' => HasMoonShineChangeLog::class,
            ])
        );

        $this->logs = $this->impersonated->changeLogs()
            ->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
            ->where('states_after', '"'.State::IMPERSONATION_ENTERED->value.'"')
            ->orderByDesc('created_at')
            ->get();
    }

    public static function count(Authenticatable $impersonated): int
    {
        return (new self($impersonated))->logs->count();
    }

    public static function lastImpersonatedBy(Authenticatable $impersonated): ?int
    {
        return (new self($impersonated))->logs?->first()?->moonshine_user_id;
    }

    public static function lastImpersonatedAt(Authenticatable $impersonated): ?Carbon
    {
        return (new self($impersonated))->logs?->first()?->updated_at;
    }
}
