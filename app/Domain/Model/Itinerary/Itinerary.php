<?php
namespace Pmp\Domain\Model\Itinerary;

use Doctrine\ORM\Mapping as ORM;
use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="itineraries")
 */
class Itinerary {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Agency\Agency", inversedBy="itineraries")
     */
    private $agency;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Market\Market", inversedBy="itineraries")
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="itineraries")
     */
    private $representativeAgent;

    public function __construct(Title $title, Agency $agency, Market $market, User $agent)
    {
        $this->title               = $title;
        $this->agency              = $agency;
        $this->market              = $market;
        $this->representativeAgent = $agent;
    }

    public function getMarket()
    {
        return $this->market;
    }

    public function getRepresentativeAgent()
    {
        return $this->representativeAgent;
    }

    public function getAgency()
    {
        return $this->agency;
    }
}