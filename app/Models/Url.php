<?php namespace Bernly\Models;

class Url extends \Model
{
    const RECENT_URL_COUNT = 5;
    const SHORT_URL_CHARACTER_SET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @summary One-to-Many relationship between a Url and UrlHits: A Url is hit many times.
     */
    public function urlHits() 
    {
        return $this->hasMany('Bernly\Models\UrlHit');
    }
    
    /**
     * @summary Many-to-One relationship between Urls and a User. 
     * @description Many Urls are shortened by only one User. It is coded here as Many-to-Many, because it is actually 
     * Many-to-One-or-Zero, and exists via an intermediate database table.
     */
    public function users() 
    {
        return $this->belongsToMany('Bernly\Models\User');
    }

    /**
     * @summary Creates a new short URL based on the next autoincremented id in the urls database table.
     *
     * @return void
     */
    public function shortenUrl()
    {
        $short_url = "";
        $character_count = strlen(self::SHORT_URL_CHARACTER_SET);
        $new_url_id = Url::all()->count() + 1;

        $counter = $new_url_id;
        while ($counter > 0) {
            $short_url = substr(self::SHORT_URL_CHARACTER_SET, ($counter % $character_count), 1) . $short_url;
            $counter = floor($counter / $character_count);
        }

        $this->short_url = $short_url;
    }
}

