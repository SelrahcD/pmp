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
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
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
   public function createFromItinerary_sets_agency_to_itinerary_agency()
   {
        $quote = Quote::createFromItinerary($this->key, $this->customer, $this->itinerary);
        $this->assertEquals($this->agency, $quote->getAgency());
   }

   /**
    * @test
    */
   public function assignToAgent_stores_assigned_agent()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
        $quote->assignToAgent($this->agent);
        $this->assertEquals($this->agent, $quote->getAssignedAgent());
   }

   /**
    * test
    * @expectedException InvalidArgumentException
    */
  public function chargingWithCommission_with_non_EUR_amount_throws_InvalidArgumentException()
  {
    $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
    $quote->chargeForCommissionableItem('truc 1', Money::USD(1000));
  }

  /**
    * test
    * @expectedException InvalidArgumentException
    */
  public function chargingWithoutCommission_with_non_EUR_amount_throws_InvalidArgumentException()
  {
    $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
    $quote->chargeForNonCommissionableItem('truc 1', Money::USD(1000));
  }

   /**
    * @test
    */
   public function getAmount_returns_the_sum_of_princing_items()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
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
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
        $quote->chargeForCommissionableItem('truc 1', Money::EUR(1000));
        $quote->chargeForCommissionableItem('truc 2', Money::EUR(500));
        $quote->chargeforNonCommissionableItem('truc 3', Money::EUR(500));
        $this->assertTrue(Money::EUR(150)->equals($quote->getCommissionAmount()));
   }

   /**
    * @test
    */
   public function removePricingItem_removes_pricing_item()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
        $quote->chargeForCommissionableItem('truc 1', Money::EUR(1000));
        $quote->chargeForCommissionableItem('truc 2', Money::EUR(500));
        $quote->chargeforNonCommissionableItem('truc 3', Money::EUR(500));
        $this->assertTrue(Money::EUR(2000)->equals($quote->getAmount()));
        $this->assertEquals(3, count($quote->getPricingItems()));

        $pricingItemToBeRemoved = $quote->getPricingItems()[0];
        $quote->removePricingItem($pricingItemToBeRemoved);

        $this->assertTrue(Money::EUR(1000)->equals($quote->getAmount()));
        $this->assertEquals(2, count($quote->getPricingItems()));
   }

   /**
    * @test
    */
  public function if_no_pricingItem_added_amount_equals_0EUR()
  {
    $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
    $this->assertTrue(Money::EUR(0)->equals($quote->getAmount()));
  }

  /**
   * @test
  */
  public function if_no_pricingItem_added_commission_equals_0EUR()
  {
    $quote = Quote::createFromScratch($this->key, $this->customer, $this->market, $this->agency);
    $this->assertTrue(Money::EUR(0)->equals($quote->getCommissionAmount()));
  }

}