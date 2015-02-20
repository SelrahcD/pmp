<?php
namespace Pmp\Domain\Model\Itinerary;

class Itinerary {

    private $agency;

    private $title;
    
    public function __construct(Title $title, Agency $agency)
    {
        $this->title = $title;
        $this->agency = $agency;
    }
}