<?php namespace Bernly\Http\Controllers;

use Bernly\Helpers\UrlHelper,
    Bernly\Models\Url,
    Bernly\Models\UrlHit,
    Bernly\Models\User,
    Bernly\Http\Requests\ShortenUrlRequest;

class HomeController extends Controller
{
    /**
     * @summary Display the home page as well as the new short url, if any,
     * and some of the last shortened URLs.
     *
     * @return Response
     */
    public function getIndex($short_url = '')
    {
        if ($short_url) {
            return UrlHelper::redirectUrl($short_url);
        }

        if (auth()->check()) {
            return view('home')->with([
                'urls' => UrlHelper::changeTimeZone(auth()->user()
                    ->urls()
                    ->orderBy('created_at', 'desc')
                    ->take(Url::RECENT_URL_COUNT)
                    ->get()
                    ->toArray())
            ]);
        }

        return view('home');
    }

    /**
     * @summary For a given long URL, create a short URL, then display the home page.
     *
     * @description Responds to HTTP POST /. If the user is logged-in, assign the URL to the user.
     *
     * @param ShortenUrlRequest $request
     *
     * @return Response
     */
    public function postIndex(ShortenUrlRequest $request)
    {
        $long_url = \Input::get('long_url');
        $url = UrlHelper::createShortUrl($long_url);
        $short_url = env('APP_URL_SHORT') . '/' . $url->short_url;

        if (auth()->check() && auth()->user()->verified) {
            UrlHelper::assignUrlToUser($url->id);
        }

        return redirect('/', compact('short_url', 'long_url'));
    }
}
