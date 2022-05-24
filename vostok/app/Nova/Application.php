<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Application extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Application::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'id', 'ticket', 'document'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make(__('Ответственный'), 'user', User::class)
                ->sortable(),
            BelongsTo::make(__('Инженер'), 'engineer', User::class)
                ->sortable(),
            BelongsTo::make(__('Диспетчер'), 'dispatcher', User::class)
                ->sortable(),
            BelongsToMany::make(__('Бригада'), 'users', User::class),
            BelongsToMany::make(__('БС'), 'stations', Station::class),
            BelongsToMany::make(__('Виды работ'), 'works', Work::class),
            BelongsTo::make('ЭУ', 'area', Area::class)
                ->sortable(),
            BelongsTo::make('Проект', 'project', Project::class)
                ->sortable(),
            BelongsTo::make('Тип', 'type', Type::class)
                ->sortable(),
            BelongsTo::make('Статус', 'status', Status::class)
                ->sortable(),
            Text::make('ПБ', 'ticket')->sortable(),
            Text::make('ОРД', 'document')->sortable(),
            Select::make('Приоритет', 'priority')->options([
                'critical' => 'Critical',
                'minor' => 'Minor',
                'major' => 'Major',
            ]),
            Text::make('Описание', 'description')
                ->sortable()->required()->hideFromIndex(),
            Text::make('Комментарий', 'comment')
                ->sortable()->required()->hideFromIndex(),
            DateTime::make(__('Deadline at'), 'deadline_at')
                ->rules('nullable', 'date'),
            DateTime::make(__('Deleted at'), 'deleted_at')
                ->onlyOnDetail()
                ->rules('nullable', 'date'),
            DateTime::make(__('Created at'), 'created_at')
                ->onlyOnDetail()
                ->showOnIndex()
                ->sortable()
                ->rules('nullable', 'date'),
            DateTime::make(__('Updated at'), 'updated_at')
                ->onlyOnDetail()
                ->rules('nullable', 'date'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
