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

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    // Matches "/api/login
    $router->post('login', 'AuthController@login');
    
    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');
    // Matches "/api/user 
    //get one user by id
    $router->get('users/{id}', 'UserController@getUser');
    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');

    // Matches "/api/payments
    $router->post('payments', 'PaymentsController@create');
 
});