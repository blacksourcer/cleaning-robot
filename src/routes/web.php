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

$router->post('/robot/clean', 'RobotController@clean');