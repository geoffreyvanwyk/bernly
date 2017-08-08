<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ErrorsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * When the app receives an HTTP request that does not contain a URL path
     * that matches the short alias of a long URL in the database, or a
     * registered route, it should display the custom 404 page.
     *
     * @test
     * @return void
     */
    public function app_shows_404_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('wrong')
                ->assertSee(
                    'A link for the ' . env('APP_SHORT_DOMAIN')
                    . ' URL you clicked, does not exist.'
                );
        });
    }
}
