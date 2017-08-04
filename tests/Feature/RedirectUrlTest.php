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
}
