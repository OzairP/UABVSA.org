<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Home;
use App\Nova\Dashboards\LotusDashboard;
use App\Nova\Dashboards\Sys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\NovaSettings\NovaSettings;
use Stepanenko3\NovaHealth\NovaHealth;

class NovaServiceProvider extends NovaApplicationServiceProvider
{

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot ()
    {
        parent::boot();

        Nova::initialPath('/dashboards/home');

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->prepend(MenuItem::externalLink('Home', '/'));

            return $menu;
        });

        Nova::footer(fn($request) => Blade::render(<<<'BLADE'
            <p class="text-center">uabvsa.org · created by <a class="link-default" href="mailto:ozairpatel2@gmail.com">Ozair Patel</a> · Phone: <a class="link-default" href="tel:+12052232952">205-223-2952</a>.</p>
BLADE
        ));

        NovaSettings::addSettingsFields([
            Boolean::make('Allow New Reservations', 'lotus_allow_new_reservations'),
            Boolean::make('Use Automatic Student Validation', 'lotus_automatic_student_validation')
                ->help('Enabling this will use automated emails to validate students. Disabling this will require manual validation. Only enable this if you\'re sure UAB students can receive emails from this server.'),
            Number::make('Student Ticket Capacity', 'lotus_ticket_student_capacity'),
            Number::make('General Ticket Capacity', 'lotus_ticket_general_capacity'),
            Text::make('Stripe Ticket Price API Id', 'lotus_stripe_ticket_price_id')
                ->help("Can be found in Stripe Product > Price API ID. This product should have the Standard Pricing model"),
            Text::make('Stripe Donation API Id', 'lotus_stripe_donation_price_id')
                ->help("Can be found in Stripe Product > Price API ID. This product should have the Customer Choose Price model"),
            URL::make('Hospitality Packet URL', 'lotus_hospitality_packet_url')
                ->help('Must be a fully qualified URL (i.e. start with https://)'),
        ], [], 'Lotus Ticket Settings');
    }

    /**
     * Register the Nova routes.
     * @return void
     */
    protected function routes ()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register ()
    {
        //
    }

    /**
     * Register the Nova gate.
     * This gate determines who can access Nova in non-local environments.
     * @return void
     */
    protected function gate (): void
    {
        if ($this->app->environment('local')) {
            Auth::loginUsingId(1);
        }

        Gate::define('viewNova', static fn(User $user) => $user->isAdmin());
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     * @return array
     */
    protected function dashboards ()
    {
        return [
            new Home,
            new LotusDashboard,
            new Sys,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     * @return array
     */
    public function tools ()
    {
        return [
            new NovaHealth,
            new NovaSettings,
        ];
    }
}
