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
     * @Given the long link I want to shorten is :longLink
     */
    public function theLongLinkIWantToShortenIs($longLink)
    {
        $this->longLink = $longLink;
    }

    /**
     * @Given the short domain name to be used for the short link is :shortDomain
     */
    public function theShortDomainNameToBeUsedForTheShortLinkIs($shortDomain)
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
     * @Given the initial number of long links already shortened with the short domain is :linkCount
     */
    public function theInitialNumberOfLongLinksAlreadyShortenedWithTheShortDomainIs($linkCount)
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
        try {
            $this->link = new Link(
                new Url($this->longLink),
                new DomainName(
                    isset($this->shortDomain) ? $this->shortDomain : $this->faker->domainName
                ),
                isset($this->oldLinkCount) ? $this->oldLinkCount : $this->faker->randomDigitNotNull

            );
        } catch (InvalidUrlException $e) {
            $this->message = $e->getMessage();
            return;
        }

        $this->links->add($this->link);
    }

    /**
     * @Then the short link I receive back should be :shortLink
     */
    public function theShortLinkIReceiveBackShouldBe($shortLink)
    {
        PHPUnit::assertSame(
            $shortLink,
            $this->link->short()
        );
    }

    /**
     * @Given the final number of long links already shortened with the short domain is :linkCount
     */
    public function theFinalNumberOfLongLinksAlreadyShortenedWithTheShortDomainIs($linkCount)
    {
        PHPUnit::assertCount(
            intval($linkCount),
            $this->links->ofShortDomain(new DomainName($this->shortDomain))
        );
    }

    /**
     * @Then I should receive back the message that :message
     */
    public function iShouldReceiveBackTheMessageThat($message)
    {
        PHPUnit::assertSame(
            $message,
            $this->message
        );
    }
}
