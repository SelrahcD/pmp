<?php

use Pmp\Domain\Model\Agency\Name;

class NameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function fromNative_returns_an_name()
    {
        $name = Name::fromNative('Poney');
        $this->assertInstanceOf('Pmp\Domain\Model\Agency\Name', $name);
    }

    /**
     * @test
     */
    public function equals_returns_true_if_emails_are_equal()
    {
        $name1 = new Name('Poney');
        $name2 = new Name('Poney');
        $this->assertTrue($name1->equals($name2));
    }

    /**
     * @test
     */
    public function equals_return_false_if_emails_are_not_equal()
    {
        $name1 = new Name('Poney');
        $name2 = new Name('Cheval');
        $this->assertFalse($name1->equals($name2));
    }

    /**
     * @test
     */
    public function toNative_returns_the_native_from_of_email()
    {
        $name = new Name('Poney');
        $this->assertEquals('Poney', $name->toNative());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_not_a_string_passed()
    {
        new Name(1);
    }
}