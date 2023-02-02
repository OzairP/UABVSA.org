<?php

namespace App\Nova;

use App\Nova\Actions\Lotus\ConfirmReservation;
use App\Nova\Actions\Lotus\DownloadTicket;
use App\Nova\Actions\Lotus\EmailTickets;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Vyuldashev\NovaMoneyField\Money;

class LotusReservation extends Resource
{

    use Actionable;

    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\LotusReservation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'holder_type',
        'name',
        'email',
        'stripe_payment_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function fields (NovaRequest $request)
    {
        return [
            ID::make()
              ->sortable(),

            Select::make('Holder Type')
                  ->options([
                      'student' => 'Student',
                      'general' => 'General Admission',
                      'sponsor' => 'Sponsor',
                  ])
                  ->sortable(),

            Text::make('Name'),

            Email::make('Email'),

            Number::make('Tickets')
                  ->sortable(),

            Boolean::make('Confirmed', 'pending')
                   ->trueValue(FALSE)
                   ->falseValue(TRUE)
                   ->sortable(),

            Heading::make('Info'),

            Textarea::make('Affiliation')
                    ->nullable(),

            Textarea::make('Dietary')
                    ->nullable()
                    ->hideFromIndex(),

            Textarea::make('Accommodations')
                    ->nullable()
                    ->hideFromIndex(),

            Heading::make('Stripe'),

            Money::make('Charged Price')
                 ->storedInMinorUnits()
                 ->sortable(),

            Money::make('Donation')
                 ->storedInMinorUnits()
                 ->sortable(),

            Text::make('Stripe Payment ID')
                ->readonly()
                ->hideFromIndex()
                ->nullable(),

            Text::make('Donation Stripe Payment ID')
                ->readonly()
                ->hideFromIndex()
                ->nullable(),

            DateTime::make('Created At')
                    ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function cards (NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function filters (NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function lenses (NovaRequest $request)
    {
        return [];
    }

    public function title ()
    {
        return "Reservation for " . $this->name;
    }

    public function subtitle ()
    {
        return "Reservation ID: " . $this->id;
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function actions (NovaRequest $request)
    {
        return [
            (new EmailTickets)->confirmText('Are you sure you want to send the ticket to the reservation email?')
                              ->confirmButtonText('Send E-Mail')
                              ->cancelButtonText('Cancel')
                              ->onlyOnDetail()
                              ->canSee(function ($request) {
                                  if ($request instanceof ActionRequest) {
                                      return TRUE;
                                  }

                                  return $this->resource instanceof \App\Models\LotusReservation && $this->resource->isConfirmed();
                              }),

            (new ConfirmReservation)->confirmText('Are you sure you want to confirm this reservation?')
                                    ->confirmButtonText('Confirm')
                                    ->cancelButtonText('Cancel')
                                    ->showOnIndex()
                                    ->showOnDetail()
                                    ->canSee(function ($request) {
                                        if ($request instanceof ActionRequest) {
                                            return TRUE;
                                        }

                                        return $this->resource instanceof \App\Models\LotusReservation && $this->resource->isPending();
                                    }),

            (new DownloadTicket)->withoutConfirmation()
                                ->canSee(function ($request) {
                                    if ($request instanceof ActionRequest) {
                                        return TRUE;
                                    }

                                    return $this->resource instanceof \App\Models\LotusReservation && $this->resource->isConfirmed();
                                }),

            (new DownloadExcel)->onlyOnIndex(),
        ];
    }


}
