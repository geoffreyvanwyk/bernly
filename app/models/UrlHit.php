<?php

class UrlHit extends Eloquent 
{
    public function urls()
    {
        return $this->belongsTo( 'URL' );
    }
}