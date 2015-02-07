<?php
namespace Pmp\Domain\Farm;

use Pmp\Domain\Market\Market;

class Farm {

    private $id;

    private $name;
    
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}