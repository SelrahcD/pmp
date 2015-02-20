<?php
namespace Pmp\Domain\Model\Quote;

use Doctrine\ORM\Mapping as ORM;
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
     **/
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Market\Market", inversedBy="markets")
     */
    private $market;

    private $itinerary;

    private $assigned_agent;

    private function __construct(Key $key, User $customer, Market $market)
    {
        $this->communication_key = $key->toNative();
        $this->customer          = $customer;
        $this->market            = $market;
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

    private function setAssociatedItinerary(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
    }
}
