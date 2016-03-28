<?php

namespace Bernly\Domain\Link;

use Bernly\Domain\Link\Url;
use Bernly\Domain\Link\Link;
use Bernly\Domain\Link\DomainName;

/**
 * A collection of Link objects.
 */
interface LinkRepository
{
    /**
     * Adds a Link object to the repository.
     *
     * @param Link $link Link to be added.
     *
     * @return void
     */
    public function add(Link $link);

    /**
     * Link with the specified long version and short domain name.
     *
     * @param Url       $longLink    Url to search by.
     * @param DominName $shortDomain Domain name to search by.
     *
     * @return Link|null
     */
    public function ofLongAndShortDomain(Url $longLink, DomainName $shortDomain);

    /**
     * Links with the specified short domain name.
     *
     * @param DominName $shortDomain Domain name to search by.
     *
     * @return Link[]
     */
    public function ofShortDomain(DomainName $shortDomain);
}
