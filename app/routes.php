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

/* Display home page, and, if any, results of URL shortening. */
Route::get('/', function()
{
	return View::make('home-page')->with('short_url', Session::get('short_url'));
});

/* For a given long URL, create a short URL. */
Route::post('/', function() 
{
	$long_url = Input::get('long_url');
	$count = Url::all()->count();
	$short_url = base_convert($count + 1, 10, 36);
	
	$url = new Url;
	$url->long_url = $long_url;
	$url->short_url = $short_url;
	$url->save();
	
	return Redirect::to('/')->with('short_url', $short_url);
});

/* For a given short URL, redirect to the corresponding long URL. */
Route::get('{short_url}', function($short_url)
{
	$url = Url::where('short_url', '=', (int)$short_url)->first();
	return Redirect::to($url['long_url']);
})
->where('short_url', '[^/]');
