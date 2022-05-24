<?php

namespace App\Nova;

use Dniccum\PhoneNumber\PhoneNumber;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'lastname';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static array $search = [
        'id', 'lastname', 'email',
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
            ID::make()->sortable(),
            Gravatar::make()->maxWidth(50),
            Text::make('Фамилия', 'lastname')
                ->sortable()
                ->required()
                ->rules('required', 'max:255'),
            Text::make('Имя', 'firstname')
                ->sortable()
                ->required()
                ->rules('required', 'max:255'),
            Text::make('Отчество', 'middlename')
                ->sortable()
                ->rules('nullable', 'max:255'),
            Text::make('Lotus Login', 'lotus_login')
                ->hideFromIndex()
                ->rules('nullable', 'max:255'),
            PhoneNumber::make('Телефон', 'phone')->sortable()
                ->required()
                ->format('+# (###) ###-##-##')
                ->countries([
                    'RU',
                    'KZ'
                ])
                ->rules(['phone:AUTO,RU,KZ']),
            BelongsTo::make('Должность', 'position', Position::class),
            BelongsTo::make('РП', 'division', Division::class),
            BelongsTo::make('Статус', 'status', UserStatus::class),
            BelongsToMany::make('Роли', 'roles', Role::class),
            Text::make('Email')
                ->sortable()
                ->required()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
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
