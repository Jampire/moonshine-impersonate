<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Exceptions\IsNotLoggableException;
use Jampire\MoonshineImpersonate\Support\Settings;
use MoonShine\Models\MoonshineUser;
use MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * Class ImpersonatedAggregationService
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonatedAggregationService
{
    private int $count = 0;

    private ?string $lastImpersonatorName = null;

    private ?Carbon $lastImpersonatedAt = null;

    public function __construct(private readonly Authenticatable $impersonated)
    {
        throw_if(
            !Settings::isImpersonationLoggable(),
            new IsNotLoggableException(),
            trans_impersonate('ui.exceptions.impersonated_not_loggable', [
                'class' => get_class($this->impersonated),
                'trait' => HasMoonShineChangeLog::class,
            ])
        );

        $this->setData();
    }

    public static function count(Authenticatable $impersonated): int
    {
        return (new self($impersonated))->getCount();
    }

    public static function lastImpersonatedBy(Authenticatable $impersonated): ?string
    {
        return (new self($impersonated))->getLastImpersonatorName();
    }

    public static function lastImpersonatedAt(Authenticatable $impersonated): ?Carbon
    {
        return (new self($impersonated))->getLastImpersonatedAt();
    }

    private function setData(): void
    {
        $key = [
            'impersonated',
            $this->impersonated->getAuthIdentifier(),
            State::IMPERSONATION_ENTERED->value,
        ];
        [$this->count, $this->lastImpersonatorName, $this->lastImpersonatedAt] =
            Cache::rememberForever(implode('::', $key), function () {
                $logs = $this->impersonated->changeLogs()
                    ->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
                    ->where('states_after', '"'.State::IMPERSONATION_ENTERED->value.'"')
                    ->latest()
                    ->get();

                $count = $logs->count();
                if ($count === 0) {
                    return [0, null, null];
                }

                $first = $logs->first();

                return [
                    $count,
                    MoonshineUser::find($first->moonshine_user_id)->name,
                    $first->created_at,
                ];
            });
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getLastImpersonatorName(): ?string
    {
        return $this->lastImpersonatorName;
    }

    public function getLastImpersonatedAt(): ?Carbon
    {
        return $this->lastImpersonatedAt;
    }
}