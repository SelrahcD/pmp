<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Domain\Model\Itinerary\Itinerary;
use Pmp\Domain\Model\Itinerary\Title;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Model\Quote\Quote;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $member;

    private $itineraries = array();

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given that I'm a member
     */
    public function thatIMAMember()
    {
        $this->member = User::register(new Email('member@poney.fr'));
    }

    /**
     * @Given that itinerary :itineraryName exists
     */
    public function thatItineraryExists($itineraryName)
    {
        $agency = Agency::referenceAgency('Poney');
        $agent = User::register(new Email('agent@poney.fr'));
        $market = new Market(new Url('http://market1.fr'));
    
        $this->itineraries[$itineraryName] = new Itinerary(new Title($itineraryName), $agency, $market, $agent);
    }

    /**
     * @When I ask for a quote for itinerary :itineraryName
     */
    public function iAskForAQuoteForItinerary($itineraryName)
    {
        $this->quote = Quote::createFromItinerary(Key::generate(), $this->member, $this->itineraries[$itineraryName]);
    }

    /**
     * @Then a quote is created for me and references itinerary :itineraryName
     */
    public function aQuoteIsCreatedForMeAndReferencesItinerary($itineraryName)
    {
        if($this->quote->getAssociatedItinerary() !== $this->itineraries[$itineraryName])
        {
            throw new Exception;
        }

        if($this->quote->getCustomer() !== $this->member)
        {
            throw new Exception;
        }

    }

}
