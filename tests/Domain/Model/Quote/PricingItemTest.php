<?php

use Pmp\Domain\Model\Quote\PricingItem;
use Money\Money;

class PricingItemTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->money = Money::EUR(1000);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */   
    public function constructor_throws_exception_if_label_is_not_a_string()
    {
        new PricingItem(4, $this->money, 0.3);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */   
    public function constructor_throws_exception_if_commission_rate_is_not_a_numeric()
    {
        new PricingItem('label', $this->money, 'bla');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */   
    public function constructor_throws_exception_if_commission_rate_is_lower_than_0()
    {
        new PricingItem('label', $this->money, -1);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */   
    public function constructor_throws_exception_if_commission_rate_is_higher_than_1()
    {
        new PricingItem('label', $this->money, 1.2);
    }

    /**
     * @test
     */
    public function getCommission_returns_the_commission()
    {
        $item = new PricingItem('label', $this->money, 0.1);
        $this->assertTrue(Money::EUR(100)->equals($item->getCommission()));
    }
}