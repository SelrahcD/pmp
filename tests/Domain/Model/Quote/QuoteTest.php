<?php

use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Domain\Model\Itinerary\Itinerary;
use Pmp\Domain\Model\Itinerary\Title;
use Pmp\Domain\Model\Agency\Agency;

class QuoteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->key = Key::generate();
        $this->customer = User::register(new Email('customer@test.fr'));
        $this->market = new Market(new Url('http://test.fr'));
        $this->agency = Agency::referenceAgency('BZHTour');
        $this->itinerary = new Itinerary(new Title('Rennes et sa région'), $this->agency, $this->market);
    }

   /**
    * @test
    */
   public function createFromScratch_returns_a_quote()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market);
        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
   }

   /**
    * @test
    */
   public function createFromItinerary_returns_a_quote()
   {
        $quote = Quote::createFromItinerary($this->key, $this->customer, $this->itinerary);
        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
   }

   /**
    * @test
    */
   public function createFromItinerary_stores_itinerary()
   {
        $quote = Quote::createFromItinerary($this->key, $this->customer, $this->itinerary);
        $this->assertEquals($this->itinerary, $quote->getAssociatedItinerary());
   }


}