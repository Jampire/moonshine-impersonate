<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Jampire\MoonshineImpersonate\Http\Concerns\WithMoonShineAuthorization;
use Jampire\MoonshineImpersonate\Rules\CanBeImpersonated;
use Jampire\MoonshineImpersonate\Rules\CanImpersonate;
use Jampire\MoonshineImpersonate\Rules\IsNotImpersonating;

/**
 * Class EnterFormRequest
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class EnterFormRequest extends FormRequest
{
    use WithMoonShineAuthorization;

    protected $stopOnFirstFailure = true;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'bail',
                new IsNotImpersonating(),
                new CanImpersonate(),
                'required',
                'int',
                'gt:0',
                new CanBeImpersonated(),
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'id' => trans_impersonate('validation.enter.id'),
        ];
    }
}
