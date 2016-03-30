<?php

namespace Bernly\Infrastructure\Persistence\InMemory\Link;

use Bernly\Domain\Link\Url;
use Bernly\Domain\Link\Link;
use Bernly\Domain\Link\DomainName;
use Bernly\Domain\Link\LinkRepository;

/**
 * An in-memory implementation of the LinkRepository that persists Link objects in an array.
 */
class ArrayLinkRepository implements LinkRepository
{
    /**
     * @var Link[]
     */
    private $links = [];

    /**
     * {@inheritdoc}
     */
    public function add(Link $link)
    {
        $this->links[] = $link;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll()
    {
        $this->links = [];
    }

    /**
     * {@inheritdoc}
     */
    public function ofShortDomain(DomainName $shortDomain)
    {
        $links = [];

        foreach ($this->links as $link) {
            if ($link->shortDomain()->equals($shortDomain)) {
                $links[] = $link;
            }
        }

        return $links;
    }

    /**
     * {@inheritdoc}
     */
    public function ofLongAndShortDomain(Url $longLink, DomainName $shortDomain)
    {
        foreach ($this->links as $link) {
            if ($link->long()->equals($longLink) and
                $link->shortDomain()->equals($shortDomain)
            ) {
                return $link;
            }
        }

        return null;
    }
}
