<?php

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'Admin'
], function ($router) {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});