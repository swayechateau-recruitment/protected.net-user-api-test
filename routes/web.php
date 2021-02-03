<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
// remove route later
$router->get('/', function () use ($router) {
    return $router->app->version();
});
// app install
$router->get('/install', 'AppController@install');
// app search queries - only users return for now
$router->get('/search', 'AppController@search');