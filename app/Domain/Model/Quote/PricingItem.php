<?php
namespace Pmp\Domain\Model\Quote;

use Money\Money;
use Assert\Assertion;

class PricingItem
{
    private $label;

    private $amount;

    private $commissionRate;

    public function __construct($label, Money $amount, $commissionRate)
    {
        Assertion::string($label);
        Assertion::numeric($commissionRate);
        Assertion::min($commissionRate, 0);
        Assertion::max($commissionRate, 1);

        $this->label          = $label;
        $this->amount         = $amount;
        $this->commissionRate = $commissionRate;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCommission()
    {
        return current($this->amount->allocate([$this->commissionRate, 1 - $this->commissionRate]));
    }
}