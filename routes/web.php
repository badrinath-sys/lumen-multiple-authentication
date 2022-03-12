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

$router->get('/', function () use ($router) {
    return $router->app->version();
    
});

$router->group(['prefix' => 'user'], function ($router) {
    $router->post('register', 'UserController@register');
});


$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('login', 'UserController@login');
});
$router->group(['prefix' => 'user', 'middleware' => 'auth'], function ($router) {
    $router->get('profile', 'UserController@profile');

});

$router->group(['prefix' => 'admin'], function ($router) {
    $router->post('login', 'AdminController@login');

    $router->group(['prefix' => 'users', 'middleware' => 'auth'], function ($router) {
        $router->get('', 'UserController@all');
    });
});