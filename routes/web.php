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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use($router) {
        $router->post('/logout', 'AuthController@logout');

        $router->get('/customers/{id}', 'CustomerController@show');
        $router->get('/customers', 'CustomerController@index');
        $router->post('/customers', 'CustomerController@store');
        $router->put('/customers/{id}', 'CustomerController@update');  // TODO: investigate why put method works with curl in terminal and fails in postman
        $router->delete('/customers/{id}', 'CustomerController@destroy');

        $router->get('/accounts/{id}', 'AccountController@show');
        $router->get('/accounts', 'AccountController@index');
        $router->post('/accounts', 'AccountController@store');
        $router->put('/accounts/{id}', 'AccountController@update');
        $router->delete('/accounts/{id}', 'AccountController@destroy');

        $router->get('/accounts/{id}/balance', 'AccountController@getBalance');
        $router->get('/accounts/{id}/history', 'AccountController@getHistory');

        $router->get('/transactions/{id}', 'TransactionController@show');
        $router->get('/transactions', 'TransactionController@index');
        $router->post('/transactions', 'TransactionController@store');
        $router->put('/transactions/{id}', 'TransactionController@update');
        $router->delete('/transactions/{id}', 'TransactionController@destroy');
        $router->post('/transactions/{id}/transfer', 'TransactionController@transfer');
     });
});
