<?php

namespace Bernly\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Bernly\Helpers\UrlHelper;
use Bernly\Http\Requests\ShortenUrlRequest;
use Bernly\Models\Url;
use Bernly\Models\UrlHit;
use Bernly\Models\User;

class HomeController extends Controller
{
    /**
     * @summary Display the home page as well as the new short url, if any.
     *
     * @description Responds to HTTP GET /. Also display some of the recent
     * URLs shorted by the logged-in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        if (auth()->check()) {
            return view('home')->with([
                'urls' => UrlHelper::changeTimeZone(
                    auth()->user()
                          ->urls()
                          ->recent()
                          ->get()
                )
            ]);
        }

        return view('home');
    }

    /**
     * @summary For a given long URL, create a short URL, then display them on
     * the home page.
     *
     * @description Responds to HTTP POST /. If the user is logged-in, assign the URL to the user.
     *
     * @param \Bernly\Http\Requests\ShortenUrlRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postIndex(ShortenUrlRequest $request)
    {
        $longUrl = $request->input('long_url');

        try {
            $url = Url::where('long_url', $longUrl)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            $url = new Url;
            $url->long_url = $longUrl;
            $url->shortenUrl();
            $url->save();
        }

        $shortUrl = config('app.url_short') . '/' . $url->short_url;

        if (auth()->check() && auth()->user()->verified) {
            UrlHelper::assignUrlToUser($url->id);
        }

        return redirect('/')->with(compact('shortUrl', 'longUrl'));
    }

    /**
     * @summary For a given short URL, redirect to the corresponding long URL.
     *
     * @param string $short_url The short URL from which the browser should
     *                          redirect to original long URL.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectUrl($short_url, Request $request)
    {
        try {
            $url = Url::where('short_url', $short_url)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $hit = new UrlHit;
        $hit->url_id = $url->id;

        if ($request->header('Referer')) {
            $hit->referer = $request->header('Referer');
        }

        $hit->save();
        return redirect($url['long_url']);
    }
}
