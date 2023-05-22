<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Jampire\MoonshineImpersonate\Http\Concerns\WithMoonShineAuthorization;
use Jampire\MoonshineImpersonate\Services\ImpersonateManager;
use Jampire\MoonshineImpersonate\Support\Settings;

/**
 * Class StopFormRequest
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class StopFormRequest extends FormRequest
{
    use WithMoonShineAuthorization;

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (!app(ImpersonateManager::class)->isImpersonating()) {
                $validator->errors()->add(
                    Settings::key(),
                    trans_impersonate('validation.stop.is_not_impersonating')
                );
            }
        });
    }
}
