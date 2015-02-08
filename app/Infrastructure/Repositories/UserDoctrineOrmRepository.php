<?php
namespace Pmp\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Pmp\Domain\Model\User\UserRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;

class UserDoctrineOrmRepository implements UserRepository
{
    private $em;

    private $class = 'Pmp\Domain\Model\User\User';

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function userOfEmail(Email $email)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'email' => $email->toNative()
        ]);
    }
}