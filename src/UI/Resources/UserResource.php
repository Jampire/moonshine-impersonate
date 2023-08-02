<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\Resources;

use Illuminate\Database\Eloquent\Model;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\UI\ItemActions\EnterImpersonationItemAction;
use MoonShine\Fields\Email;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

/**
 * Class UserResource
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class UserResource extends Resource
{
//    public static string $orderType = 'ASC';

    // TODO: parent::softDeletes() ???
    public function getModel(): Model
    {
        $model = Settings::userClass();

        return new $model();
    }

    public function title(): string
    {
        return trans_impersonate('ui.resource.users.title');
    }

    public function fields(): array //
	{
		return [
		    ID::make()->sortable(),
            Text::make(trans_impersonate('ui.resource.users.fields.name'), 'name'),
            Email::make(trans_impersonate('ui.resource.users.fields.email'), 'email'),
            NoInput::make(trans_impersonate('ui.resource.users.fields.impersonated_count'), ''), // TODO: ???
            NoInput::make(trans_impersonate('ui.resource.users.fields.last_impersonated_by'), ''), // TODO: ???
            NoInput::make(trans_impersonate('ui.resource.users.fields.last_impersonated_at'), ''), // TODO: ???
        ];
	}

	public function rules(Model $item): array //
	{
	    return [];
    }

    public function search(): array //
    {
        return ['id'];
    }

    public function filters(): array //
    {
        return [];
    }

    public function actions(): array //
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

    public function itemActions(): array //
    {
        return [
            EnterImpersonationItemAction::make()->resolve(),
        ];
    }
}
