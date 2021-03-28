<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'auth'], function ($route) {
        $route->post('login', '\App\Api\Auth\Controllers\AuthController@login');
    });
});

$router->group(['middleware' => 'jwt.auth', 'prefix' => 'api'], function ($router) {
    /** Users Routes */
    $router->group(['prefix' => 'user'], function ($route) {
        $route->get('/', '\App\Api\Users\Controllers\UserController@index');
        $route->get('/{id:[0-9]+}', '\App\Api\Users\Controllers\UserController@show');
        $route->post('/', '\App\Api\Users\Controllers\UserController@store');
        $route->put('/{id:[0-9]+}', '\App\Api\Users\Controllers\UserController@update');
        $route->delete('/{id:[0-9]+}', '\App\Api\Users\Controllers\UserController@destroy');
    });

    /** Books Routes */
    $router->group(['prefix' => 'book'], function ($route) {
        $route->get('/', '\App\Api\Books\Controllers\BookController@index');
        $route->get('/{id:[0-9]+}', '\App\Api\Books\Controllers\BookController@show');
        $route->post('/', '\App\Api\Books\Controllers\BookController@store');
        $route->put('/{id:[0-9]+}', '\App\Api\Books\Controllers\BookController@update');
        $route->delete('/{id:[0-9]+}', '\App\Api\Books\Controllers\BookController@destroy');

        /** Favorite your book Routes */
        $route->group(['prefix' => 'favorite'], function ($router) {
            $router->post('/save', '\App\Api\Books\Controllers\BookController@saveFavorite');
            $router->post('/remove', '\App\Api\Books\Controllers\BookController@removeFavorite');
        });
    });
});
