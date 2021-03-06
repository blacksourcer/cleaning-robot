<?php

require_once __DIR__.'/../vendor/autoload.php';

defined("ROOT_DIR") || define("ROOT_DIR", __DIR__ . "/..");
defined("APP_DIR") || define("APP_DIR", ROOT_DIR . "/app");
defined("TESTS_DIR") || define("TESTS_DIR", ROOT_DIR . "/tests");
defined("TESTS_DATA_DIR") || define("TESTS_DATA_DIR", TESTS_DIR . "/data");
defined("TESTS_TMP_DIR") || define("TESTS_TMP_DIR", TESTS_DIR . "/tmp");

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$app->register(App\Providers\AppServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function (/** @noinspection PhpUnusedParameterInspection */ $router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
