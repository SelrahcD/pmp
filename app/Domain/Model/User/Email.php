<?php
namespace Pmp\Domain\Model\User;

use Assert\Assertion;

class Email {

    private $value;

    public function __construct($value)
    {
        Assertion::email($value);
        
        $this->value = $value;
    }

    static public function fromNative($native)
    {
        return new self($native);
    }

    public function equals(Email $email)
    {
        return $this == $email;
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