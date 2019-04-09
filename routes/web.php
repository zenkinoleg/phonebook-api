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

//$router->group(['middleware' => ['app']], function () use ($router) {
	$router->post('login', 'UsersController@login');
	$router->group(['middleware' => ['cache','auth']], function () use ($router) {
		$router->get('phonebook[/{id}]', 'PhonebookController@get');
		$router->post('phonebook[/{id}]', 'PhonebookController@add');
		$router->delete('phonebook/{id}', 'PhonebookController@delete');
	});
//});
