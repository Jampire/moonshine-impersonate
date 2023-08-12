<?php

declare(strict_types=1);

namespace Jampire\MoonshineImpersonate\UI\Resources;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Jampire\MoonshineImpersonate\Enums\State;
use Jampire\MoonshineImpersonate\Scopes\ExcludeMyselfScope;
use Jampire\MoonshineImpersonate\Services\ImpersonatedAggregationService;
use Jampire\MoonshineImpersonate\Support\Settings;
use Jampire\MoonshineImpersonate\UI\ItemActions\EnterImpersonationItemAction;
use MoonShine\Decorations\Block;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\MorphMany;
use MoonShine\Fields\MorphToMany;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Text;
use MoonShine\Filters\SwitchBooleanFilter;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

/**
 * Class ImpersonatedResource
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * TODO: install script
 */
class ImpersonatedResource extends Resource
{
    public static bool $withPolicy = false; // TODO: true

    public static string $orderField = 'id';

    public static string $orderType = 'ASC';

    public static array $activeActions = ['show'];

    protected bool $showInModal = true;

    public string $titleField = 'name';

    public static int $itemsPerPage = 25; // TODO

    private readonly bool $isImpersonationLoggable;

    public function __construct()
    {
        $this->isImpersonationLoggable = Settings::isImpersonationLoggable($this->getModel());
    }

    public function getModel(): Model
    {
        $model = Settings::userClass();

        return new $model();
    }

    public function title(): string
    {
        return trans_impersonate('ui.resources.impersonated.title');
    }

//    public function getWith(): array
//    {
//        return $this->isImpersonationLoggable ? ['changeLogs'] : [];
//    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return config_impersonate('resources.impersonated.items_per_page');
    }

    // TODO: make by filters
//    public function performOrder(Builder $query, string $column, string $direction): Builder
//    {
//        if ($this->isImpersonationLoggable) {
//            return $query->orWhereHas('changeLogs', function (Builder $builder) {
//                $builder->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
//                    ->where('states_after', '"'.State::IMPERSONATION_ENTERED->value.'"')
//                    ->latest();
//            });
//        }
//
//        return $query->orderBy('id');
//    }

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
        ];

        if ($this->isImpersonationLoggable) {
            // TODO: sort
            $fields[] = NoInput::make(
                trans_impersonate('ui.resources.impersonated.fields.impersonated_count'),
                'impersonated_count',
                fn (Authenticatable $item) => ImpersonatedAggregationService::count($item),
            );

            $fields[] = NoInput::make(
                trans_impersonate('ui.resources.impersonated.fields.last_impersonated_by'),
                'last_impersonated_by',
                fn (Authenticatable $item) => ImpersonatedAggregationService::lastImpersonatedBy($item),
            ); // TODO: badge admin

            $fields[] = Date::make(
                trans_impersonate('ui.resources.impersonated.fields.last_impersonated_at'),
                'last_impersonated_at',
                fn (Authenticatable $item) => ImpersonatedAggregationService::lastImpersonatedAt($item),
            )->format(config_impersonate('resources.impersonated.fields.date_format'));
        }

        return $fields;
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return [
            'id',
            config_impersonate('resources.impersonated.fields.name'),
            config_impersonate('resources.impersonated.fields.email'),
        ];
    }

    public function queryTags(): array
    {
        if (!$this->isImpersonationLoggable) {
            return [];
        }

        return [
            QueryTag::make(
                trans_impersonate('ui.resources.impersonated.filters.impersonated_only'),
                fn (Builder $query) => $query->whereHas('changeLogs', function (Builder $builder) {
                    $builder->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
                        ->orWhere('states_before', '"'.State::IMPERSONATION_ENTERED->value.'"');
                })
            ),

            QueryTag::make(
                trans_impersonate('ui.resources.impersonated.filters.all'),
                fn (Builder $query) => $query
            ),
        ];
    }

    public function filters(): array //
    {
        return [
            SwitchBooleanFilter::make(
                trans_impersonate('ui.resources.impersonated.filters.impersonated_only'),
                'impersonated_count',
                fn (Builder $query) => $query->whereHas('changeLogs', function (Builder $builder) {
                    $builder->where('states_before', '"'.State::IMPERSONATION_STOPPED->value.'"')
                        ->orWhere('states_before', '"'.State::IMPERSONATION_ENTERED->value.'"');
                })
            ),
        ];
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

    public function scopes(): array
    {
        return  [
            new ExcludeMyselfScope(),
        ];
    }
}
