<?php
namespace Pmp\Domain\Model\User\Specifications;

use Pmp\Domain\Model\User\UserRepository;

class EmailIsUniqueSpecification
{
    private $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isSatisfiedBy($email)
    {
        return $this->userRepository->userOfEmail($email) === null;
    }
}