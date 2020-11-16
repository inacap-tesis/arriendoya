<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function () {
                require base_path('routes/web.php');
                require base_path('routes/web/antecedente.php');
                require base_path('routes/web/anuncio.php');
                require base_path('routes/web/arriendo.php');
                require base_path('routes/web/calificacion.php');
                require base_path('routes/web/catalogo.php');
                require base_path('routes/web/cuentaBancaria.php');
                require base_path('routes/web/deuda.php');
                require base_path('routes/web/garantia.php');
                require base_path('routes/web/inmueble.php');
                require base_path('routes/web/interesAnuncio.php');
                require base_path('routes/web/notificacion.php');
                require base_path('routes/web/solicitudFinalizacion.php');
            });
            //->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
