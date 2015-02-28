<?php

use Pmp\Domain\Model\Itinerary\Title;

class TitleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function fromNative_returns_an_title()
    {
        $title = Title::fromNative('Poney');
        $this->assertInstanceOf('Pmp\Domain\Model\Itinerary\Title', $title);
    }

    /**
     * @test
     */
    public function equals_returns_true_if_titles_are_equal()
    {
        $title1 = new Title('Poney');
        $title2 = new Title('Poney');
        $this->assertTrue($title1->equals($title2));
    }

    /**
     * @test
     */
    public function equals_return_false_if_titles_are_not_equal()
    {
        $title1 = new Title('Poney');
        $title2 = new Title('Cheval');
        $this->assertFalse($title1->equals($title2));
    }

    /**
     * @test
     */
    public function toNative_returns_the_native_from_of_title()
    {
        $title = new Title('Poney');
        $this->assertEquals('Poney', $title->toNative());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_not_a_string_passed()
    {
        new Title(1);
    }

    /**
     * @test
     */
    public function toString_returns_value()
    {
        $title = new Title('Poney');
        $this->assertEquals('Poney', $title->__toString());
    }
}