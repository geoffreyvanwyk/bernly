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

Route::get('/', function()
{
	return View::make('home-page')->with('short_url', Session::get('short_url'));
});

/* Create a short url. */
Route::post('/', function() 
{
	$count = Url::all()->count();
	$short_url = base_convert($count + 1, 10, 36);
	
	$url = new Url;
	$url->long_url = Input::get('long_url');
	$url->short_url = $short_url;
	$url->save();
	
	return Redirect::to('/')->with('short_url', $short_url);
});
