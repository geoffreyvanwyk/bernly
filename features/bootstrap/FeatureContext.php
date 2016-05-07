<?php

namespace Bernly\Feature;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

use Faker\Factory as FakeFactory;
use PHPUnit_Framework_Assert as PHPUnit;

use Bernly\Domain\Link\Url;
use Bernly\Domain\Link\Link;
use Bernly\Domain\Link\DomainName;
use Bernly\Domain\Link\InvalidUrlException;
use Bernly\Infrastructure\Persistence\InMemory\Link\ArrayLinkRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->links = new ArrayLinkRepository();
        $this->faker = FakeFactory::create();
    }

    /**
     * @Transform /^(\d+)$/
     */
    public function castStringToNumber($string)
    {
        return intval($string);
    }

    /**
     * @Given the system uses :shortDomain as the domain name for the short link
     */
    public function theSystemUsesAsTheDomainNameForTheShortLink($shortDomain)
    {
        $this->shortDomain = new DomainName($shortDomain);
    }

    /**
     * @Given I want to shorten the long link :longLink
     */
    public function iWantToShortenTheLongLink($longLink)
    {
        try {
            $this->longLink = new Url($longLink);
        } catch (InvalidUrlException $e) {
            $this->message = $e->getMessage();
        }
    }

    /**
     * @Given the number of long links already shortened with the short domain is :initialLinkCount
     */
    public function theNumberOfLongLinksAlreadyShortenedWithTheShortDomainIs($initialLinkCount)
    {
        $this->initialLinkCount = $initialLinkCount;
        $this->links->removeAll();

        for ($i = 1; $i <= $this->initialLinkCount; $i++) {
            $this->links->add(new Link(
                new Url($this->faker->url),
                $this->shortDomain,
                $this->initialLinkCount
            ));
        }

        PHPUnit::assertCount(
            $this->initialLinkCount,
            $this->links->ofShortDomain($this->shortDomain)
        );
    }

    /**
     * @Given the long link has been shortened before to :shortLink
     */
    public function theLongLinkHasBeenShortenedBeforeTo($shortLink)
    {
        $this->link = new Link(
            $this->longLink,
            $this->shortDomain,
            $this->convertPathToCount($this->path($shortLink))
        );

        $this->links->add($this->link);

        $existingLink = $this->links->ofLongAndShortDomain(
            $this->longLink,
            $this->shortDomain
        );

        PHPUnit::assertInstanceOf(Link::class, $existingLink);
        PHPUnit::assertTrue(
            $existingLink->short()->equals(new Url($shortLink))
        );
    }

    /**
     * @Given I want to follow the short link :shortLink
     */
    public function iWantToFollowTheShortLink($shortLink)
    {
        $this->shortLink = new Url($shortLink);
    }

    /**
     * @Given the short link has been created from the long link :originalLongLink
     */
    public function theShortLinkHasBeenShortenedFrom($originalLongLink)
    {
        $this->originalLongLink = new Url($originalLongLink);

        $this->links->add(new Link(
            $this->originalLongLink,
            $this->shortDomain,
            $this->convertPathToCount($this->path($this->shortLink->uri()))
        ));

        PHPUnit::assertTrue(
            $this->links->ofLongAndShortDomain(
                $this->originalLongLink,
                $this->shortDomain
            )->short(
            )->equals($this->shortLink)
        );
    }

    /**
     * @Given the short link does not exist
     */
    public function theShortLinkDoesNotExist()
    {
        PHPUnit::assertNull($this->links->ofShort($this->shortLink));
    }

    /**
     * @When I shorten the long link
     */
    public function iShortenTheLongLink()
    {
        /* Scenarios under which $this->initialLinkCount will not have been set
         * at this point:
         *
         *   - "Long link is not a valid URL"
         *   - "Long link has been shortened before"
         */
        $initialLinkCount = isset($this->initialLinkCount) ?
            $this->initialLinkCount : $this->faker->randomDigitNotNull;

        /* Scenarios under which $this->longLink will not have been set at this
         * point:
         *
         *   - "Long link is not a valid URL"
         *
         */
        $longLink = isset($this->longLink) ?
            $this->longLink : new Url($this->faker->url);

        $existingLink = $this->links->ofLongAndShortDomain(
            $longLink,
            $this->shortDomain
        );

        $this->link = isset($existingLink) ? $existingLink : new Link(
            $longLink,
            $this->shortDomain,
            $initialLinkCount
        );
    }

    /**
     * @When I follow the short link
     */
    public function iFollowTheShortLink()
    {
        $link = $this->links->ofShort($this->shortLink);

        if ($link) {
            $this->longLink = $link->long();
        } else {
            $this->message = "The short link has not been created yet.";
        }
    }

    /**
     * @Then the system should give the short link :shortLink to me
     */
    public function theSystemShouldGiveTheShortLinkToMe($shortLink)
    {
        PHPUnit::assertTrue($this->link->short()->equals(new Url($shortLink)));
    }

    /**
     * @Then the final number of long links shortened with the short domain is :finalLinkCount
     */
    public function theFinalNumberOfLongLinksShortenedWithTheShortDomainIs($finalLinkCount)
    {
        $this->links->add($this->link);

        PHPUnit::assertCount(
            $finalLinkCount,
            $this->links->ofShortDomain($this->shortDomain)
        );
    }

    /**
     * @Then the system should redirect me to the long link
     */
    public function theSystemShouldRedirectMeToTheLongLink()
    {
        PHPUnit::assertTrue($this->longLink->equals($this->originalLongLink));
    }

    /**
     * @Then the system should tell me that :message
     */
    public function theSystemShouldTellMeThat($message)
    {
        PHPUnit::assertSame($message, $this->message);
    }

    /**
     * Converts the path of a short link to the initial number of links.
     *
     * @return int
     */
    private function convertPathToCount($path)
    {
        $base = strlen(Link::SHORT_URL_CHARACTER_SET);
        $count = 0;

        for ($i = 0; $i < strlen($path); $i++) {
            $count += ($base ** $i) * strpos(
                Link::SHORT_URL_CHARACTER_SET,
                $path[strlen($path) - 1]
            );
        }

        return $count - 1;
    }

    /**
     * Returns the path of a short link.
     *
     * @return string
     */
    private function path($link)
    {
        $parts = explode('/', $link);

        return $parts[count($parts) - 1];
    }
}
