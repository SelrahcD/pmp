<?php
namespace Pmp\Domain\User;

class Guest extends User {
    
    public function becomeMember($password)
    {
        return new Member($this->id, $this->email, $password);
    }
}