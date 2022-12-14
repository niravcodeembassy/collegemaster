<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Events\RouteMatched;

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


    Route::bind('locale', function ($value) {
      return $value;
    });
  }

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map()
  {
    $this->mapApiRoutes();

    $this->mapAdminRoutes();


    $this->mapWebRoutes();

    //
  }

  /**
   * Define the "admin" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function mapAdminRoutes()
  {
    Route::prefix('admin')
      ->middleware('web')
      ->namespace($this->namespace)
      ->group(base_path('routes/admin.php'));
  }

  /**
   * Define the "web" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
  function parseLocale()
  {
    $locale = request()->segment(1);
    $languages = config('app.locales');
    if (in_array($locale, $languages)) {
      app()->setlocale($locale);
      return $locale;
    }
    return '/';
  }

  protected function mapWebRoutes()
  {
    Route::middleware('web')
      ->namespace($this->namespace)
      ->group(base_path('routes/web.php'));
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