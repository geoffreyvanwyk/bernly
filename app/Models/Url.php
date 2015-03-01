<?php namespace Bernly\Models;

class Url extends \Eloquent
{
    /**
     * @summary One-to-Many relationship between a Url and UrlHits: A Url is hit many times.
     */
    public function urlHits() 
    {
        return $this->hasMany( 'UrlHit' );
    }
    
    /**
     * @summary Many-to-One relationship between Urls and a User: Many Urls are shortened by only one User. 
     * It is coded here as Many-to-Many, because it is actually Many-to-One-or-Zero, and exists via an 
     * intermediate database table.
     */
    public function users() 
    {
        return $this->belongsToMany( 'User' );
    }
}
