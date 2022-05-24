<?php

namespace App\Nova;

use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Address extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Address::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'title',
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
            BelongsTo::make('РП', 'division', Division::class)
                ->sortable(),
            BelongsTo::make('Область', 'state', State::class)
                ->sortable(),
            BelongsTo::make('Регион', 'region', Region::class)
                ->sortable(),
            BelongsTo::make('Населенный пункт', 'city', City::class)
                ->sortable(),
            Text::make('Название', 'title'),
            Text::make('Адрес', 'address'),
            MapMarker::make('Location')
                ->latitude('latitude')
                ->longitude('longitude')
                ->searchProvider('openstreetmap')
                ->defaultLatitude('44.590467181309')
                ->defaultLongitude('75.863960935793')
                ->defaultZoom(5)
                ->required(),
            Number::make('МРП', 'mci')->min(1),
            Currency::make('Стоимость', 'cost')
                ->currency('KZT'),
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
