<?php namespace Bernly\Models;

class UrlHit extends \Eloquent 
{
    public function urls()
    {
        return $this->belongsTo( 'Bernly\Models\Url' );
    }
}
