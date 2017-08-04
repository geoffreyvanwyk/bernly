<?php

namespace Tests\Unit;

use App\Link;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Map numbers in base 10 to numbers in base 62.
     *
     * @var array
     */
    protected $map = [
        1 => '1',
        5 => '5',
        9 => '9',
        10 => 'a',
        22 => 'm',
        35 => 'z',
        36 => 'A',
        48 => 'M',
        61 => 'Z',
        63 => '11',
        1387 => 'mn',
        28486 => '7ps',
        39134 => 'abc',
    ];

    /**
     * Test that the correct alias is produced for a given id.
     *
     * @test
     * @return void
     */
    public function can_get_link_alias()
    {
        foreach ($this->map as $base_10 => $base_62) {
            $link = factory(Link::class)->make();
            $link->id = $base_10;
            $this->assertEquals($base_62, $link->alias);
        }
    }

    /**
     * Test that the correct link is found for a given alias.
     *
     * @test
     * @return void
     */
    public function can_get_link_from_alias()
    {
        foreach ($this->map as $base_10 => $base_62) {
            $link = factory(Link::class)->create(['id' => $base_10]);
            $this->assertEquals($base_10, Link::findFromAlias($base_62)->id);
        }
    }
}
