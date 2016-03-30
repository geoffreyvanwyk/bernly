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
     * @Given I want to shorten the long link :longLink
     */
    public function iWantToShortenTheLongLink($longLink)
    {
        $this->longLink = $longLink;
    }

    /**
     * @Given the system uses :shortDomain as the short domain name
     */
    public function theSystemUsesAsTheShortDomainName($shortDomain)
    {
        $this->shortDomain = $shortDomain;
    }

    /**
     * @Given the long link has not been shortened with the short domain before
     */
    public function theLongLinkHasNotBeenShortenedWithTheShortDomainBefore()
    {
        PHPUnit::assertNull(
            $this->links->ofLongAndShortDomain(
                new Url($this->longLink),
                new DomainName($this->shortDomain)
            )
        );
    }

    /**
     * @Given the number of long links already shortened with the short domain is :initialLinkCount
     */
    public function theNumberOfLongLinksAlreadyShortenedWithTheShortDomainIs($initialLinkCount)
    {
        $this->links->removeAll();

        $this->initialLinkCount = intval($initialLinkCount);

        for ($i = 0; $i < $this->initialLinkCount; $i++) {
            $this->links->add(
                new Link(
                    new Url($this->faker->url),
                    new DomainName($this->shortDomain),
                    $this->initialLinkCount
                )
            );
        }

        PHPUnit::assertCount(
            $this->initialLinkCount,
            $this->links->ofShortDomain(new DomainName($this->shortDomain))
        );
    }

    /**
     * @When I shorten the long link
     */
    public function iShortenTheLongLink()
    {
        try {
            $this->link = new Link(
                new Url($this->longLink),
                new DomainName(
                    isset($this->shortDomain) ? $this->shortDomain : $this->faker->domainName
                ),
                isset($this->initialLinkCount) ? $this->initialLinkCount : $this->faker->randomDigitNotNull

            );
        } catch (InvalidUrlException $e) {
            $this->message = $e->getMessage();
            return;
        }

        $this->links->add($this->link);
    }

    /**
     * @Then the system should give the short link :shortLink to me
     */
    public function theSystemShouldGiveTheShortLinkToMe($shortLink)
    {
        PHPUnit::assertSame(
            $shortLink,
            $this->link->short()
        );
    }

    /**
     * @Then the final number of long links shortened with the short domain is :finalLinkCount
     */
    public function theFinalNumberOfLongLinksShortenedWithTheShortDomainIs($finalLinkCount)
    {
        PHPUnit::assertCount(
            intval($finalLinkCount),
            $this->links->ofShortDomain(new DomainName($this->shortDomain))
        );
    }

    /**
     * @Then the short link should point to the long link
     */
    public function theShortLinkShouldPointToTheLongLink()
    {
        throw new PendingException();
    }

    /**
     * @Then the system should tell me that :message
     */
    public function theSystemShouldTellMeThat($message)
    {
        PHPUnit::assertSame(
            $message,
            $this->message
        );
    }
}
