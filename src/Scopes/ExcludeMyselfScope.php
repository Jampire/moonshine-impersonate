<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class ExcludeMyselfScope
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ExcludeMyselfScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $defaultAuthGuard = config_impersonate('default_auth_guard');
        if (auth($defaultAuthGuard)->check()) {
            $builder->whereNot('id', auth($defaultAuthGuard)->id());
        }
    }
}
