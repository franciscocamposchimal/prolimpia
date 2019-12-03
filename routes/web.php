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
    // Matches "/api/users/register
    $router->post('users/register', 'AuthController@register');
    // Matches "/api/users/login
    $router->post('users/login', 'AuthController@login');
    // Matches "/api/users/check
    $router->get('users/check', 'AuthController@check');
    // Matches "/api/users/check
    $router->get('users/logout', 'AuthController@logout');
    
    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');
    // Matches "/api/user 
    //get one user by id
    $router->get('users/{id}', 'UserController@getUser');
    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');
    
    /*--- RECOLECTA_COBROS ---*/
    // Matches "/api/persons
    $router->get('persons', 'PersonController@allPersons');
    // Matches "/api/persons
    $router->put('persons/{id}', 'PersonController@getCobro');
});