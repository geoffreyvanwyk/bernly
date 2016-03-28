<?php

namespace Bernly\Domain\Link;

use Bernly\Domain\Link\Url;
use Bernly\Domain\Link\DomainName;

class Link
{
    const SHORT_URL_CHARACTER_SET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $shortDomain;

    public function __construct(Url $longLink, DomainName $shortDomain, $oldLinkCount)
    {
        $this->long = $longLink;
        $this->shortDomain = $shortDomain;
        $this->oldLinkCount = $oldLinkCount;
    }

    public function shortDomain()
    {
        return $this->shortDomain;
    }

    public function short()
    {
        $shortLink = '';
        $characterCount = strlen(self::SHORT_URL_CHARACTER_SET);
        $counter = $this->oldLinkCount + 1;

        while ($counter > 0) {
            $shortLink = substr(self::SHORT_URL_CHARACTER_SET, ($counter % $characterCount), 1) . $shortLink;
            $counter = floor($counter / $characterCount);
        }

        return $this->shortDomain->value() . '/' . $shortLink;
    }
}