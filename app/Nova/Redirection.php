<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Redirection extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Redirection::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'slug';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'slug',
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
            ID::make()->sortable(),

            Text::make('Slug')
                ->required()
                ->rules('required', 'max:255', 'min:1')
                ->creationRules('unique:redirections')
                ->showOnDetail(false)
                ->filterable(),

            URL::make('Slug', fn () => url("/{$this->slug}"))
                ->displayUsing(fn () => url("/{$this->slug}"))
                ->onlyOnDetail(),

            URL::make('Redirects To')
                ->required()
                ->rules('required', 'max:255', 'min:1', 'active_url')
                ->displayUsing(fn () => $this->redirects_to)
                ->filterable(),

            Number::make('Clicks')
                ->filterable()
                ->sortable()
                ->readonly()
                ->exceptOnForms(),

            DateTime::make('Last Clicked At', 'updated_at')
                ->filterable()
                ->sortable()
                ->readonly()
                ->exceptOnForms(),

            DateTime::make('Created At')
                    ->filterable()
                    ->sortable()
                    ->readonly()
                    ->exceptOnForms()
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
