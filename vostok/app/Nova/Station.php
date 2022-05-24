<?php

namespace App\Nova;

use Davidpiesse\Map\Map;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Station extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Station::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'bts_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'bts_id',
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
            BelongsTo::make('Тип', 'stationType', StationType::class)
                ->sortable()
                ->required(),
            BelongsTo::make('РП', 'division', Division::class)
                ->sortable()
                ->required(),
            BelongsTo::make('ЭУ', 'area', Area::class)
                ->sortable()
                ->required(),
            BelongsTo::make('Область', 'state', State::class)
                ->sortable()
                ->required(),
            BelongsTo::make('Район', 'region', Region::class)
                ->sortable()
                ->required(),
            BelongsTo::make('Населенный пункт', 'city', City::class)
                ->sortable()
                ->required(),
            BelongsTo::make('Проект', 'project', Project::class)
                ->sortable()
                ->required(),
            Text::make('BTS ID', 'bts_id')
                ->sortable()
                ->required(),
            Text::make('Наименование БС на RAC', 'rac')
                ->required(),
            Text::make('Наименование', 'title')
                ->sortable()->required()->hideFromIndex(),
            MapMarker::make('Location')
                ->latitude('latitude')
                ->longitude('longitude')
                ->searchProvider('openstreetmap')
                ->defaultLatitude('44.590467181309')
                ->defaultLongitude('75.863960935793')
                ->defaultZoom(5)
                ->required(),
            Text::make('Комментарий', 'comment')
                ->required()
                ->hideFromIndex(),
            Text::make('Поставка', 'supply')
                ->hideFromIndex(),
            Number::make('Расстояние, км', 'distance')
                ->step(0.01),
            Text::make('Высота опоры, м', 'prop_height')
                ->hideFromIndex(),
            Text::make('Тип опоры', 'prop_type')
                ->hideFromIndex(),
            Number::make('Высота подвеса антенны, А', 'antenna_suspension_height_a')
                ->step(0.01),
            Number::make('Высота подвеса антенны, B', 'antenna_suspension_height_b')
                ->step(0.01),
            Number::make('Высота подвеса антенны, C', 'antenna_suspension_height_c')
                ->step(0.01),
            Number::make('Азимуты антенн/угол наклона, А', 'antenna_azimuths_tilt_angle_a')
                ->step(0.01),
            Number::make('Азимуты антенн/угол наклона, B', 'antenna_azimuths_tilt_angle_b')
                ->step(0.01),
            Number::make('Азимуты антенн/угол наклона, C', 'antenna_azimuths_tilt_angle_c')
                ->step(0.01),
            Text::make('Место установки оборудования', 'equipment_installation_location')
                ->hideFromIndex(),
            Text::make('Место установки антенн', 'antenna_installation_location')
                ->hideFromIndex(),
            Text::make('Наличие гарантированного питания от ДГА', 'guaranteed_power')
                ->hideFromIndex(),
            Text::make('Тип стойки ЭП', 'stand_type')
                ->hideFromIndex(),
            Text::make('Тип выпрямительных блоков', 'rectifier_units_type')
                ->hideFromIndex(),
            Number::make('Кол-во выпрямительных блоков', 'number_rectifier_units')
                ->step(1),
            Number::make('Емкость АКБ (А)', 'battery_capacity')
                ->step(1),
            Number::make('Кол-во АКБ', 'battery_count')
                ->step(1),
            Number::make('Приоритет', 'priority')
                ->step(1),
            Number::make('Номер заказа', 'order_number')
                ->step(1),
            Number::make('Дополнение к заказу', 'order_additional')
                ->step(1),
            Text::make('Subcon', 'subcon')
                ->hideFromIndex(),
            Text::make('Комментарий', 'comment')
                ->hideFromIndex(),
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
