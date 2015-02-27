<?php

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Domain\Model\Itinerary\Itinerary;
use Pmp\Domain\Model\Itinerary\Title;


class ItineraryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->agency = Agency::referenceAgency('Poney');
        $this->agent = User::register(new Email('agent@poney.fr'));
        $this->productionManager = User::register(new Email('prod@poney.fr'));
        $this->market = new Market(new Url('http://market1.fr'));

        $this->itinerary = new Itinerary(new Title('Poney'), $this->agency, $this->market, $this->agent);
    }

    /**
     * @test
     */
    public function itinerary_is_online_if_agency_is_online_on_market()
    {
        $this->agency->prospect($this->market, $this->productionManager);
        $this->agency->setOnline($this->market);
        $this->assertTrue($this->agency->isOnlineOn($this->market));
        $this->assertTrue($this->itinerary->isOnline());
    }

    /**
     * @test
     */
    public function itinerary_is_offline_if_agency_is_offline_on_market()
    {
        $this->agency->prospect($this->market, $this->productionManager);
        $this->assertFalse($this->agency->isOnlineOn($this->market));
        $this->assertFalse($this->itinerary->isOnline());
    }
}