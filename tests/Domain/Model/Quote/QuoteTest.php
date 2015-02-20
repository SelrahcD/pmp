<?php

use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;


class QuoteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->key = Key::generate();
        $this->customer = User::register(new Email('customer@test.fr'));
        $this->market = new Market(new Url('http://test.fr'));
    }

   /**
    * @test
    */
   public function createFromScratch_returns_a_quote()
   {
        $quote = Quote::createFromScratch($this->key, $this->customer, $this->market);
        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
   }


}