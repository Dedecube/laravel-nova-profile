<?php

namespace Dedecube\Profile;

use Dedecube\Profile\Contracts\PasswordUpdateRequestInterface;
use Dedecube\Profile\Contracts\PasswordUpdaterInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Dedecube\Profile\Http\Middleware\Authorize;
use Dedecube\Profile\Http\Requests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/nova-profile.php' => config_path('nova-profile.php'),
        ]);

        Validator::extend('hash_match', function ($attribute, $value, $parameters, $validator) {
            $hashedCodeFromDb = $parameters[0];

            return Hash::check($value, $hashedCodeFromDb);
        });

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'profile')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/profile')
            ->group(__DIR__ . '/../routes/api.php');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-profile.php',
            'nova-profile'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PasswordUpdaterInterface::class, PasswordUpdater::class);
        $this->app->bind(PasswordUpdateRequestInterface::class, PasswordUpdateRequest::class);
    }
}
