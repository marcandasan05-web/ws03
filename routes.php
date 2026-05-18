<?php

$router->get('/', 'HomeController@index');

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->post('/logout', 'AuthController@logout');

$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
$router->post('/listings', 'ListingController@store');
$router->get('/listings/{id}/edit', 'ListingController@edit');
$router->get('/listings/{id}/delete', 'ListingController@destroyForm');
$router->post('/listings/{id}/delete', 'ListingController@destroy');
$router->put('/listings/{id}', 'ListingController@update');
$router->get('/listings/{id}', 'ListingController@show');
