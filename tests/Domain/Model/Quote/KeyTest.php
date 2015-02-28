<?php

use Pmp\Domain\Model\Quote\Key;

class KeyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function fromNative_returns_a_Key()
    {
        $key = Key::fromNative('okay!');
        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Key', $key);
    }

    /**
     * @test
     */
    public function equals_returns_true_if_keys_are_equal()
    {
        $key1 = new Key('okay!');
        $key2 = new Key('okay!');
        $this->assertTrue($key1->equals($key2));
    }

    /**
     * @test
     */
    public function equals_return_false_if_keys_are_not_equal()
    {
        $key1 = new Key('poney');
        $key2 = new Key('okay!');
        $this->assertFalse($key1->equals($key2));
    }

    /**
     * @test
     */
    public function toNative_returns_the_native_form_of_key()
    {
        $key = new Key('okay!');
        $this->assertEquals('okay!', $key->toNative());
    }

    /**
     * @test
     */
    public function generate_returns_a_Key()
    {
        $key = Key::generate();
        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Key', $key);
    }

    /**
     * @test
     */
    public function generate_returns_a_new_Key_each_time()
    {
        $key1 = Key::generate();
        $key2 = Key::generate();
        $this->assertFalse($key1->equals($key2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_value_is_not_a_string()
    {
        new Key(1);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_value_is_5_char_long()
    {
        new Key('toolong');
    }

    /**
     * @test
     */
    public function toString_returns_value()
    {
        $key = new Key('Poney');
        $this->assertEquals('Poney', $key->__toString());
    }
}