<?php

namespace Bernly\Helpers;

use Bernly\Models\Url;
use Bernly\Models\UrlUser;

class UrlHelper
{
    public static function assignUrlToUser($url_id)
    {
        try {
            $user_url = new UrlUser;
            $user_url->user_id = \Auth::user()->id;
            $user_url->url_id = $url_id;
            $user_url->save();
        } catch (\Exception $exception) {
        }
    }

    public static function changeTimeZone($urls)
    {
        $urls_with_hits = [];

        $db_time_zone = new \DateTimeZone( 'UTC' );
        $user_timezone = new \DateTimeZone( \Auth::user()->timezone );

        foreach ( $urls as $url ) {
            $created_at = new \DateTime( $url['created_at'], $db_time_zone );
            $created_at->setTimeZone( $user_timezone );
            $url['created_at'] = $created_at->format( 'Y-m-d H:i:s' );

            $url['hits'] = Url::find( $url['id'] )->urlHits()->count();
            $urls_with_hits[] = $url;
        }

        return $urls_with_hits;
    }
}
