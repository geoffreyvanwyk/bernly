<?php

class HomeController extends BaseController {

	/**
	 * @summary Display the home page, as well as the new short url, if any.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        if ( Auth::check() ) {
            $user = User::find( Auth::user()->id );
            $urls = $user->urls->toArray();
            $urls_with_hits = array();
            
            foreach ( $urls as $url ) {
                $url['hits'] = Url::find( $url['id'] )->urlHits()->count();
                $urls_with_hits[] = $url;
            }
            
            return View::make( 'home' )->with( 'urls', $urls_with_hits );
        }
        
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
            
            $user_url = new UrlUser;
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
		
		if ( Request::header( 'Referer' ) ) {
            $url_hit->referer = Request::header( 'Referer' );
        }
        
		$url_hit->save();
		
		return Redirect::to( $url['long_url'] );
	}
}
