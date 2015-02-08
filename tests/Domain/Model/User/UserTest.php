<?php

use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function register_returns_a_user()
    {
        $user = User::register(new Email('toto@test.fr'));
        $this->assertInstanceOf('Pmp\Domain\Model\User\User', $user);
    }

    /**
     * @test
     */
    public function register_stores_UserRegistered_event()
    {
        $user = User::register(new Email('toto@test.fr'));
        $events = $user->getRecordedEvents();
        $this->assertInstanceOf('Pmp\Domain\Model\User\Events\UserRegistered', reset($events));
    }
}