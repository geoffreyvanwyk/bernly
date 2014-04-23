<?php

class HomeController extends BaseController {

	/**
	 * @summary Display the home page, as well as the new short url, if any.
	 *
	 * @return Response
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
		
		if ( Auth::check() ) {
            
            $user_url = new UserUrl;
            $user_url->user_id = Auth::user()->id;
            $user_url->url_id = $url->id;
            $user_url->save();
            
		}
		
		return Redirect::to( '/' )->with( array( 
            'short_url' => Config::get( 'app.url_no_protocol' ).'/'.$short_url, 
            'long_url' => $long_url 
        ));
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
		
		$url_hit = new UrlHit;
		$url_hit->url_id = $url->id;
		$url_hit->referer = Request::header( 'Referer' );
		$url_hit->save();
		
		return Redirect::to( $url['long_url'] );
	}
}
