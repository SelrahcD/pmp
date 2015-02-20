<?php
namespace Pmp\Domain\Model\Itinerary;

use Assert\Assertion;

class Title {

    private $value;

    public function __construct($value)
    {
        Assertion::string($value);
        
        $this->value = $value;
    }

    static public function fromNative($native)
    {
        return new self($native);
    }

    public function equals(Title $title)
    {
        return $this == $title;
    }

    public function toNative()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}