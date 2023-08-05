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
use MoonShine\Traits\Models\HasMoonShineChangeLog;

/**
 * Class ImpersonatedResource
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 */
class ImpersonatedResource extends Resource
{
//    public static string $orderType = 'ASC';
    public static bool $withPolicy = false; // TODO: true

    public static string $orderField = 'id'; // TODO: last_impersonated_at

    public static string $orderType = 'DESC';

    public static array $activeActions = ['show'];

    protected bool $showInModal = true;

    public static int $itemsPerPage = 25;

    public function getModel(): Model
    {
        $model = Settings::userClass();

        return new $model();
    }

    public function title(): string
    {
        return trans_impersonate('ui.resources.impersonated.title');
    }

    public function fields(): array
	{
		$fields = [
		    ID::make()->sortable(),
            Text::make(
                trans_impersonate('ui.resources.impersonated.fields.name'),
                config_impersonate('resources.impersonated.fields.name'),
            )->sortable(),
            Email::make(
                trans_impersonate('ui.resources.impersonated.fields.email'),
                config_impersonate('resources.impersonated.fields.email'),
            )->sortable(),
//            NoInput::make(trans_impersonate('ui.resources.impersonated.fields.impersonated_count'), ''), // TODO: ???
//            NoInput::make(trans_impersonate('ui.resources.impersonated.fields.last_impersonated_by'), ''), // TODO: ???
//            NoInput::make(trans_impersonate('ui.resources.impersonated.fields.last_impersonated_at'), ''), // TODO: ???
        ];

        if (Settings::isImpersonationLoggable()) {

        }

        return $fields;
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

    public function itemActions(): array
    {
        return [
            EnterImpersonationItemAction::make()->resolve(false)->showInLine(),
        ];
    }
}
