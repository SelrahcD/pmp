<?php
namespace Pmp\Domain\Service\User;

use Pmp\Domain\Model\User\UserRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\User\Specifications\EmailIsUniqueSpecification;
use InvalidArgumentException;

class RegisterUserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($email)
    {
        $email = new Email($email);

        $this->checkEmailIsUnique($email);

        $user = User::register($email);

        $this->userRepository->add($user);

        return $user;
    }
    
    private function checkEmailIsUnique(Email $email)
    {
        $specification = new EmailIsUniqueSpecification($this->userRepository);

        if(!$specification->isSatisfiedBy($email)) {
            throw new InvalidArgumentException($email . ' is already taken');
        }
    }
}