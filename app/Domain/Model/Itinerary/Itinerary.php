<?php
namespace Pmp\Domain\Model\Itinerary;

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Market\Market;

class Itinerary {

    private $title;

    private $agency;
    
    private $market;

    public function __construct(Title $title, Agency $agency, Market $market)
    {
        $this->title = $title;
        $this->agency = $agency;
        $this->market = $market;
    }

    public function getMarket()
    {
        return $this->market;
    }
}