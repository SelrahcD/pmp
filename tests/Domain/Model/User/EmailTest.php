<?php

use Pmp\Domain\Model\User\Email;

class EmailTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function fromNative_returns_an_email()
    {
        $email = Email::fromNative('toto@test.fr');
        $this->assertInstanceOf('Pmp\Domain\Model\User\Email', $email);
    }

    /**
     * @test
     */
    public function equals_returns_true_if_emails_are_equal()
    {
        $email1 = new Email('toto@test.fr');
        $email2 = new Email('toto@test.fr');
        $this->assertTrue($email1->equals($email2));
    }

    /**
     * @test
     */
    public function equals_return_false_if_emails_are_not_equal()
    {
        $email1 = new Email('toto@test.fr');
        $email2 = new Email('plop@test.fr');
        $this->assertFalse($email1->equals($email2));
    }

    /**
     * @test
     */
    public function toNative_returns_the_native_from_of_email()
    {
        $email = new Email('toto@test.fr');
        $this->assertEquals('toto@test.fr', $email->toNative());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function constructor_throws_InvalidArgumentException_if_unvalid_email_passed()
    {
        $email = new Email('bla');
    }
}