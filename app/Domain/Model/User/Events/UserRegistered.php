<?php
namespace Pmp\Domain\Model\User\Events;

use Pmp\Domain\Model\User\Email;

class UserRegistered
{
    private $email;

    public function __construct(Email $email)
    {
        $this->email = $email->toNative();
    }

    public function getEmail()
    {
        return Email::fromNative($this->email);
    }
}