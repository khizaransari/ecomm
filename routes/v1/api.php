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


// $router->post('product', 'ProductController@store');
// $router->get('products', 'ProductController@index');

$router->group(['prefix' => 'products'], function () use ($router) {
    $router->get('/', 'ProductController@index');
    $router->post('create', 'ProductController@create');
    $router->get('show/{id}', 'ProductController@show');
    $router->put('update/{id}', 'ProductController@update');
    $router->delete('delete/{id}', 'ProductController@destroy');
});
