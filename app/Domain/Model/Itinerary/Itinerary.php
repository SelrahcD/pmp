<?php
namespace Pmp\Domain\Model\Itinerary;

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\User\User;

class Itinerary {

    private $title;

    private $agency;
    
    private $market;

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
}