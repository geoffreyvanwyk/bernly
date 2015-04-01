<?php namespace Bernly\Http\Controllers;

use Bernly\Helpers\UrlHelper, 
    Bernly\Models\Url, 
    Bernly\Models\UrlHit, 
    Bernly\Models\User;

class HomeController extends Controller 
{
    /**
     * @summary Display the home page, as well as the new short url, if any.
     *
     * @return Response
     */
    public function getIndex()
    {
        if ( \Auth::check() ) {
            $urls = \Auth::user() 
                ->urls()
                ->orderBy( 'created_at', 'desc' )
                ->take(Url::RECENT_URL_COUNT)
                ->get()
                ->toArray();

            $urls = UrlHelper::changeTimeZone($urls);

            return \View::make( 'home' )->with( 'urls', $urls );
        }

        return \View::make( 'home' );
    }

    /**
     * @summary For a given long URL, create a short URL.
     *
     * @description Responds to HTTP POST /. If the user is logged-in, assign the URL to the user.
     *
     * @return Response
     */
    public function postIndex()
    {
        $long_url = \Input::get( 'long_url' );
        $url = UrlHelper::createShortUrl( $long_url );
        $short_url = \Config::get( 'app.url_no_protocol' ) . '/' . $url->short_url;

        if ( \Auth::check() ) {
            UrlHelper::assignUrlToUser( $url->id );
        }

        return \Redirect::to( '/' )->with([ 
            'short_url' => $short_url,
            'long_url' => $long_url
        ]);
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
        $url = Url::where( 'short_url', '=', $short_url )->firstOrFail();

        $url_hit = new UrlHit;
        $url_hit->url_id = $url->id;

        if ( \Request::header( 'Referer' ) ) {
            $url_hit->referer = \Request::header( 'Referer' );
        }

        $url_hit->save();

        return \Redirect::to( $url['long_url'] );
    }
}

