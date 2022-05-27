<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @extends App\Model\User
 */
class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'nickname', 'email'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->readonly(),

            Avatar::make('Avatar')
                ->maxWidth(128)
                ->thumbnail(fn()=>$this->avatar)
                ->preview(fn()=>$this->avatar)
                ->download(fn()=>$this->avatar)
                ->showOnIndex()
                ->readonly(),

            Text::make('Nickname')
                ->required()
                ->sortable()
                ->filterable()
                ->readonly(),

            Text::make('Email')
                ->required()
                ->sortable()
                ->filterable()
                ->readonly(),

            Text::make('Discord ID')
                ->required()
                ->sortable()
                ->filterable()
                ->readonly(),

            DateTime::make('Joined At')
                ->required()
                ->sortable()
                ->filterable()
                ->readonly(),

            DateTime::make('Last Logged In', 'updated_at'),

            Code::make('Roles', fn () => $this->resolveRoles())
                ->json()
                ->onlyOnDetail()
                ->readonly(),

            Password::make('Access Token')
                ->onlyOnDetail()
                ->readonly(),

            Password::make('Refresh Token')
                ->onlyOnDetail()
                ->readonly()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
