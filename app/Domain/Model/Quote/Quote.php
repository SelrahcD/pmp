<?php
namespace Pmp\Domain\Model\Quote;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Itinerary\Itinerary;

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

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assigned_agent;

    private $pricingItems;

    private function __construct(Key $key, User $customer, Market $market)
    {
        $this->communication_key = $key->toNative();
        $this->customer          = $customer;
        $this->market            = $market;
        $this->pricingItems      = new ArrayCollection();
    }

    public function createFromScratch(Key $key, User $customer, Market $market)
    {
        return new self($key, $customer, $market);
    }

    public function createFromItinerary(Key $key, User $customer, Itinerary $itinerary)
    {
        $quote = new self($key, $customer, $itinerary->getMarket());

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

    public function chargeForCommissionableItem($label, $amount)
    {
        $this->pricingItems[] = new PricingItem($label, $amount, 0.10);
    }

    public function chargeForNonCommissionableItem($label, $amount)
    {
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
        $total = null;

        foreach($this->pricingItems as $pricingItem)
        {
            if(!$total) {
                $total = $pricingItem->getAmount();
            }
            else {
                $total = $total->add($pricingItem->getAmount());
            }
        }

        return $total;
    }

    public function getCommissionAmount()
    {
        $total = null;

        foreach($this->pricingItems as $pricingItem)
        {
            if(!$total) {
                $total = $pricingItem->getCommission();
            }
            else {
                $total = $total->add($pricingItem->getCommission());
            }
        }

        return $total;
    }

    private function setAssociatedItinerary(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
    }
}
