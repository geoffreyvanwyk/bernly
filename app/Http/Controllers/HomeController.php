<?php namespace Bernly\Http\Controllers;

use Auth, Config, Input, Redirect, Request, View;
use Bernly\Helpers\UrlHelper;

class HomeController extends Controller 
{
    const RECENT_URL_COUNT = 5;

    /**
     * @summary Display the home page, as well as the new short url, if any.
     *
     * @return Response
     */
    public function getIndex()
    {
        if ( Auth::check() ) {
            $user = User::find( Auth::user()->id );

            $urls = $user
                ->urls()
                ->orderBy( 'created_at', 'desc' )
                ->take(self::RECENT_URL_COUNT)
                ->get()
                ->toArray();

            $urls_with_hits = UrlHelper::changeTimeZone($urls);

            return View::make( 'home' )->with( 'urls', $urls_with_hits );
        }

        return View::make( 'home' );
    }

    /**
     * @summary For a given long URL, create a short URL.
     *
     * @return Response
     */
    public function postIndex()
    {
        $long_url = Input::get( 'long_url' );
        $url = UrlHelper::createShortUrl($long_url);

        if ( Auth::check() ) {
            UrlHelper::assignUrlToUser( $url->id, Auth::user()->id );
        }

        return Redirect::to( '/' )->with( array(
            'short_url' => Config::get( 'app.url_no_protocol' ) . '/' . $url->short_url,
            'long_url' => $long_url
        ));
    }

    /**
     * @summary For a given short URL, redirect to the corresponding long URL.
     *
     * @param string $short_url The short URL from which the browser should redirect to original long URL.
     *
     * @return Response
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

