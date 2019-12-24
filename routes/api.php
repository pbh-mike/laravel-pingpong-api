<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::patch('update', 'AuthController@update');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::get('events', 'EventsController@index');
Route::post('events', 'EventsController@store');
Route::patch('events/{id}', 'EventsController@update');
Route::delete('events/{id}', 'EventsController@destroy');
