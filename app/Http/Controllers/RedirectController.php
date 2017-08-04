<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    /**
     * Redirect a link alias to the corresponding long URL.
     *
     * @param string $alias
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectUrl(string $alias) : RedirectResponse
    {
        $link = Link::findFromAlias($alias);
        return redirect($link->url);
    }
}
