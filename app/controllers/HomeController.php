<?php

class HomeController extends BaseController {

	/**
	 * @summary Display the home page, as well as the new short url, if any.
	 *
	 * @return void
	 */
	public function getIndex()
	{
		return View::make( 'home' );
	}
	
	/**
	 * @summary For a given long URL, create a short URL.
	 *
	 * @return void
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
	 * @summary For a given short URL, redirect to the corresponding long URL. 
	 * 
	 * @param string $short_url The short URL from which the browser should redirect to original long URL.
	 *
	 * @return void
	 */
	public function redirectUrl( $short_url )
	{
		$url = Url::where( 'short_url', '=', (int) $short_url )->firstOrFail();
		return Redirect::to( $url['long_url'] );
	}
}
