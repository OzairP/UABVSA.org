<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\LotusDashboard;
use App\Nova\Dashboards\Home;
use App\Nova\Dashboards\Sys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
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
            <p class="text-center">uabvsa.org · created by <a class="link-default" href="mailto:ozairpatel2@gmail.com">Ozair Patel</a>.</p>
            <p class="text-center">Powered by <a class="link-default" href="https://nova.laravel.com">Laravel Nova</a> · v4.7.0 (Silver Surfer)</p>
BLADE
        ));

        NovaSettings::addSettingsFields([
            Boolean::make('Allow New Reservations', 'lotus_allow_new_reservations'),
            Number::make('Ticket Capacity', 'lotus_ticket_capacity'),
            Text::make('Stripe Product Id', 'lotus_stripe_product_id'),
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
            new Sys
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
            new NovaSettings
        ];
    }
}
