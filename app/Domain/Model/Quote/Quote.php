<?php
namespace Pmp\Domain\Model\Quote;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Itinerary\Itinerary;
use Pmp\Domain\Model\Agency\Agency;
use Money\Money;
use Money\Currency;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="quotes")
 */
class Quote {

    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $communication_key;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="quotes")
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Market\Market", inversedBy="markets")
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Itinerary\Itinerary", inversedBy="quotes")
     */
    private $itinerary;

    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assigned_agent;

    private $pricingItems;

    private function __construct(Key $key, User $customer, Market $market, Agency $agency)
    {
        $this->communication_key = $key->toNative();
        $this->customer          = $customer;
        $this->market            = $market;
        $this->agency            = $agency;
        $this->pricingItems      = new ArrayCollection();
    }

    public function createFromScratch(Key $key, User $customer, Market $market, Agency $agency)
    {
        return new self($key, $customer, $market, $agency);
    }

    public function createFromItinerary(Key $key, User $customer, Itinerary $itinerary)
    {
        $quote = new self($key, $customer, $itinerary->getMarket(), $itinerary->getAgency());

        $quote->setAssociatedItinerary($itinerary);

        $quote->assignToAgent($itinerary->getRepresentativeAgent());

        return $quote;
    }

    public function getAssociatedItinerary()
    {
        return $this->itinerary;
    }

    public function assignToAgent(User $agent)
    {
        $this->assigned_agent = $agent;
    }

    public function getAssignedAgent()
    {
        return $this->assigned_agent;
    }

    public function getAgency()
    {
        return $this->agency;
    }

    public function chargeForCommissionableItem($label, Money $amount)
    {
        $this->ensureMoneyIsInEUR($amount);
        $this->pricingItems[] = new PricingItem($label, $amount, 0.10);
    }

    public function chargeForNonCommissionableItem($label, Money $amount)
    {
        $this->ensureMoneyIsInEUR($amount);
        $this->pricingItems[] = new PricingItem($label, $amount, 0);
    }

    public function getPricingItems()
    {
        return $this->pricingItems;
    }

    public function removePricingItem(PricingItem $pricingItem)
    {
        $this->pricingItems->removeElement($pricingItem);
    }

    public function getAmount()
    {
        return array_reduce($this->pricingItems->toArray(), function($total, $pricingItem) {
            if(!$total) {
                return $pricingItem->getAmount();
            }

            return $total->add($pricingItem->getAmount());
        }, Money::EUR(0));
    }

    public function getCommissionAmount()
    {
        return array_reduce($this->pricingItems->toArray(), function($total, $pricingItem) {
            if(!$total) {
                return $pricingItem->getCommission();
            }

            return $total->add($pricingItem->getCommission());
        }, Money::EUR(0));
    }

    private function setAssociatedItinerary(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
    }

    private function ensureMoneyIsInEUR(Money $money)
    {
        if(! $money->getCurrency()->equals(new Currency('EUR'))){
            throw new InvalidArgumentException('Only EUR is allowed');
        }
    }
}
