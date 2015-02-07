<?php
namespace Pmp\Domain\User;

class User {

    protected $id;

    protected $email;

    protected $password;
    
    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
    }
}