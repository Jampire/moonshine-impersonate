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
final class EnterFormRequest extends FormRequest
{
    use WithMoonShineAuthorization;

    protected $stopOnFirstFailure = true;

    /**
     * @return array{id: IsNotImpersonating[]|CanImpersonate[]|CanBeImpersonated[]|string[]}
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
     * @return array{id: string}
     */
    public function attributes(): array
    {
        return [
            'id' => trans_impersonate('validation.enter.id'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $key = config_impersonate('resource_item_key');

        if ($this->has($key)) {
            $this->merge([
                'id' => (int)$this->get($key),
            ]);
        }
    }
}
