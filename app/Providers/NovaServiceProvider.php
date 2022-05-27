<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot ()
    {
        parent::boot();

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->prepend(MenuItem::externalLink('Home', '/'));

            return $menu;
        });

        Nova::footer(fn($request) => Blade::render(<<<'BLADE'
            <p class="text-center">uabvsa.org · created by <a class="link-default" href="mailto:ozairpatel2@gmail.com">Ozair Patel</a>.</p>
            <p class="text-center">Powered by <a class="link-default" href="https://nova.laravel.com">Laravel Nova</a> · v4.7.0 (Silver Surfer)</p>
BLADE
        ));
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
        Gate::define('viewNova', fn(User $user) => $user->isAdmin());
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     * @return array
     */
    protected function dashboards ()
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     * @return array
     */
    public function tools ()
    {
        return [];
    }
}
