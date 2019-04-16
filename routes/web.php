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

$router->post('login', 'UsersController@login');
$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('phonebook[/{id}]', 'PhonebookController@get');
    $router->post('phonebook[/{id}]', 'PhonebookController@add');
    $router->delete('phonebook/{id}', 'PhonebookController@delete');
});
