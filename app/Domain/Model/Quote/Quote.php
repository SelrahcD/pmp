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

    public function __construct(Key $key, User $customer, Market $market)
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

        return $quote;
    }

    public function getAssociatedItinerary()
    {
        return $this->itinerary;
    }

    private function setAssociatedItinerary($itinerary)
    {
        $this->itinerary = $itinerary;
    }
}
