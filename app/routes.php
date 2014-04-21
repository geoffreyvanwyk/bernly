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

/* This route must be first; otherwise, a 'Controller method not found.' exception will be thrown. */
Route::get( '{short_url}', 'HomeController@redirectUrl' )->where( 'short_url', '[^/]' );

Route::controller( 'user', 'UserController' );

/* This route must be last; otherwise, a 'Controller method not found.' exception will be thrown. */
Route::controller( '/', 'HomeController' );
