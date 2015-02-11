<?php
namespace Pmp\Domain\Model\Market;

use Assert\Assertion;

class Url
{
    private $value;

    public function __construct($value)
    {
        Assertion::url($value);

        $this->value = $value;
    }

    static public function fromNative($native)
    {
        return new self($native);
    }

    public function equals(Url $url)
    {
        return $this == $url;
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