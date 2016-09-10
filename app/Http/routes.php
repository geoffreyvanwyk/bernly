<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group([
    'prefix' => 'user'
], function () {
    Route::get('/', 'UserController@getIndex');
    Route::get('add', 'UserController@getAdd');
    Route::post('add', 'UserController@postAdd');

    Route::group([
        'middleware' => 'auth'
    ], function () {
        Route::get('view', 'UserController@getView');

        Route::get('edit-email', 'UserController@getEditEmail');
        Route::post('edit-email', 'UserController@postEditEmail');

        Route::get('edit-password', 'UserController@getEditPassword');
        Route::post('edit-password', 'UserController@postEditPassword');

        Route::get('edit-timezone', 'UserController@getEditTimezone');
        Route::post('edit-timezone', 'UserController@postEditTimezone');

        Route::get('remove', 'UserController@getRemove');

        Route::get('links', 'UserController@getLinks');
        Route::get('link/{url_id}', 'UserController@getLink');
    });
});

Route::group([
    'prefix' => 'verify'
], function () {
    Route::get('/', ['middleware' => 'auth'], 'VerifyController@getIndex');
    Route::get('email', 'VerifyController@getEmail');
});

Route::controllers([
    'log' => 'LoginController',
    'password' => 'RemindersController'
]);

Route::get('/', 'HomeController@getIndex');
Route::post('/', 'HomeController@postIndex');
Route::get('/{short_url}', 'HomeController@redirectUrl');
