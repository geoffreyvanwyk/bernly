<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;

use PHPUnit_Framework_Assert as PHPUnit;

use Faker\Factory as FakeFactory;

use Bernly\Domain\Link\Url;
use Bernly\Domain\Link\Link;
use Bernly\Domain\Link\DomainName;
use Bernly\Infrastructure\Persistence\InMemory\Link\InMemoryLinkRepository;

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
        $this->links = new InMemoryLinkRepository();
        $this->faker = FakeFactory::create();
    }

    /**
     * @Given long link I want to shorten is :longLink
     */
    public function longLinkIWantToShortenIs($longLink)
    {
        $this->longLink = $longLink;
    }

    /**
     * @Given short domain name to be used for the short link is :shortDomain
     */
    public function shortDomainNameToBeUsedForTheShortLinkIs($shortDomain)
    {
        $this->shortDomain = $shortDomain;
    }

    /**
     * @Given long link is a valid URL
     */
    public function longLinkIsAValidURL()
    {
        $url = new Url($this->longLink);
    }

    /**
     * @Given short domain is a valid domain name
     */
    public function shortDomainIsAValidDomainName()
    {
        $domain = new DomainName($this->shortDomain);
    }

    /**
     * @Given long link has not been shortened with the short domain before
     */
    public function longLinkHasNotBeenShortenedWithTheShortDomainBefore()
    {
        PHPUnit::assertNull(
            $this->links->ofLongAndShortDomain(
                new Url($this->longLink),
                new DomainName($this->shortDomain)
            )
        );
    }

    /**
     * @Given number of long links already shortened with the short domain is :linkCount
     */
    public function numberOfLongLinksAlreadyShortenedWithTheShortDomainIs($linkCount)
    {
        $this->oldLinkCount = intval($linkCount);

        for ($i = 0; $i < $this->oldLinkCount; $i++) {
            $this->links->add(
                new Link(
                    new Url($this->faker->url),
                    new DomainName($this->shortDomain),
                    $this->oldLinkCount
                )
            );
        }

        PHPUnit::assertCount(
            $this->oldLinkCount,
            $this->links->ofShortDomain(new DomainName($this->shortDomain))
        );
    }

    /**
     * @When I shorten the long link
     */
    public function iShortenTheLongLink()
    {
        $this->link = new Link(
            new Url($this->longLink),
            new DomainName($this->shortDomain),
            $this->oldLinkCount
        );

        $this->links->add($this->link);
    }

    /**
     * @Then short link I receive back should be :shortLink
     */
    public function shortLinkIReceiveBackShouldBe($shortLink)
    {
        PHPUnit::assertSame(
            $shortLink,
            $this->link->short()
        );
    }

    /**
     * @Given new number of long links already shortened with the short domain is :linkCount
     */
    public function newNumberOfLongLinksAlreadyShortenedWithTheShortDomainIs($linkCount)
    {
        PHPUnit::assertCount(
            intval($linkCount),
            $this->links->ofShortDomain(new DomainName($this->shortDomain))
            );
    }
}
