<?php

/** @var \Laravel\Lumen\Routing\Router $router */


/**
 * Application Routes
 *  */

// App docs
$router->get('/', 'AppController@index');
// App install
$router->get('/install', 'AppController@install');
// App search queries - only users return for now
$router->get('/search', 'AppController@search');

/**
 * Users crud routes
 *  */
// Get all Users
$router->get('/users', 'UserController@index');
// Add a user
$router->post('/users', 'UserController@create');
// Get a user
$router->get('/users/{id}', 'UserController@show');
// Update a user - only name supported currently
$router->put('/users/{id}', 'UserController@update');
// Delete a user
$router->delete('/users/{id}', 'UserController@destroy');

// Toggle a users darkmode setting
$router->get('/users/{id}/tdm', 'UserController@toggleDarkMode');