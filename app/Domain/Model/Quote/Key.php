<?php
namespace Pmp\Domain\Model\Quote;

use Assert\Assertion;

class Key {

    const KEY_LENGTH = 5;

    private $value;

    public function __construct($value)
    {
        Assertion::string($value);
        Assertion::length($value, self::KEY_LENGTH);

        $this->value = $value;
    }

    static public function generate()
    {
        return new self(self::getRandomString(self::KEY_LENGTH));
    }

    static public function fromNative($native)
    {
        return new self($native);
    }

    public function equals(Key $key)
    {
        return $this == $key;
    }

    public function toNative()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    static private function getRandomString($length)
    {
        return substr(str_shuffle(MD5(microtime())), 0, $length);
    }
    
}