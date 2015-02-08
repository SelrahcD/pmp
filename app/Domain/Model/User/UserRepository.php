<?php
namespace Pmp\Domain\Model\User;

interface UserRepository
{
    public function add(User $user);

    public function userOfEmail(Email $email);
}