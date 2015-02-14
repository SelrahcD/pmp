<?php
namespace Pmp\Domain\Model\Agency;

use Assert\Assertion;

class Name {

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

    public function equals(Name $name)
    {
        return $this == $name;
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