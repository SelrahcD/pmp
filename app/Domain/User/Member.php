<?php
namespace Pmp\Domain\User;

class Member extends User {

    public function __construct($id, $email, $password)
    {
        parent::__construct($id, $email);
        $this->password = $password;
    }
    
}