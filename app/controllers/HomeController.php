<?php

class HomeController extends BaseController {

	/**
	 * Display the home page, as well as the new short url, if any.
	 */
	public function getIndex()
	{
		return View::make( 'home' )->with( 'short_url', Session::get( 'short_url' ) );
	}
	
	/**
	* For a given long URL, create a short URL.
	*/
	public function postIndex()
	{
		$long_url = Input::get( 'long_url' );
		$count = Url::all()->count();
		$short_url = base_convert( $count + 1, 10, 36 );
		
		$url = new Url;
		$url->long_url = $long_url;
		$url->short_url = $short_url;
		$url->save();
		
		return Redirect::to( '/' )->with( 'short_url', $short_url );
	}
	
	/** 
	* For a given short URL, redirect to the corresponding long URL. 
	*/
	public function redirectUrl($short_url)
	{
		$url = Url::where( 'short_url', '=', (int) $short_url )->firstOrFail();
		return Redirect::to( $url['long_url'] );
	}
}
