<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Link;

class RedirectUrlTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * When the app receives an HTTP request containing a URL path that matches
     * the short alias of a long URL in the database, it should redirect the
     * request to the long URL.
     *
     * @test
     * @return void
     */
    public function app_can_redirect_short_url()
    {
        // Arrange
        $link = factory(Link::class)->create();

        // Act
        $response = $this->get($link->alias);

        // Assert
        $response->assertRedirect($link->url);
    }

    /**
     * When the app receives an HTTP request containing a URL path that does
     * not match the short alias of a long URL in the database, or a registered
     * route, it should display the custom 404 page.
     *
     * @test
     * @return void
     */
    public function app_shows_404_page_for_unknown_short_url()
    {
        // Act
        $response = $this->get('wrong');

        // Assert
        $response->assertStatus(404);
    }
}
