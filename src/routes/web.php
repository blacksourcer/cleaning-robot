<?php
/**
 * @var \Laravel\Lumen\Routing\Router $router
 */
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$router->get('/', 'IndexController@index');
$router->get('/error', 'IndexController@error');

//$router->post('/robot/clean')