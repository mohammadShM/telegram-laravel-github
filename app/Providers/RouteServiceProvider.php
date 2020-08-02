<?php

namespace App\Providers;

use App\Chat;
use App\Contact;
use App\Message;
use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;
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
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->registerRouteModels();
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
        // for my customize router ======
        $files = File::files(base_path('routes/api'));
        foreach ($files as $file) {
            $path = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $name = $file->getFilenameWithoutExtension();
            Route::prefix("api/{$name}")
                ->middleware('api')
                ->namespace($this->namespace)
                ->group($path);
        }
    }

    private function registerRouteModels()
    {
        Route::model('chat', Chat::class);
        Route::model('contact', Contact::class);
        Route::model('message', Message::class);
        Route::model('user', User::class);
    }
}