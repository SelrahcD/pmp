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
use Money\Money;

class QuoteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->key = Key::generate();
        $this->customer = User::register(new Email('customer@test.fr'));
        $this->agent = User::register(new Email('agent@test.fr'));
        $this->market = new Market(new Url('http://test.fr'));
        $this->agency = Agency::referenceAgency('BZHTour');
        $this->itinerary = new Itinerary(new Title('Rennes et sa région'), $this->agency, $this->market, $this->agent);
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

   /**
    * @test
    */
   public function createFromItinerary_auto_assigns_to_itinerary_representative_agent()
   {
        $quote = Quote::createFromItinerary($this->key, $this->customer, $this->itinerary);
        $this->assertEquals($this->agent, $quote->getAssignedAgent());
   }

   /**
    * @test
    */
   public function assignToAgent_stores_assigned_agent()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market);
        $quote->assignToAgent($this->agent);
        $this->assertEquals($this->agent, $quote->getAssignedAgent());
   }

   /**
    * @test
    */
   public function getAmount_returns_the_sum_of_princing_items()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market);
        $quote->chargeForCommissionableItem('truc 1', Money::EUR(1000));
        $quote->chargeForCommissionableItem('truc 2', Money::EUR(500));
        $quote->chargeforNonCommissionableItem('truc 3', Money::EUR(500));
        $this->assertTrue(Money::EUR(2000)->equals($quote->getAmount()));
   }

   /**
    * @test
    */
   public function getCommissionAmount_returns_the_sum_of_commissionable_princing_items()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market);
        $quote->chargeForCommissionableItem('truc 1', Money::EUR(1000));
        $quote->chargeForCommissionableItem('truc 2', Money::EUR(500));
        $quote->chargeforNonCommissionableItem('truc 3', Money::EUR(500));
        $this->assertTrue(Money::EUR(150)->equals($quote->getCommissionAmount()));
   }

}