<?php

use Mockery as m;
use Pmp\Domain\Model\User\Specifications\EmailIsUniqueSpecification;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\User\User;

class EmailIsUniqueSpecificationTest extends PHPUnit_Framework_TestCase
{
    private $specification;

    private $repository;

    public function setUp()
    {
        $this->repository = m::mock('Pmp\Domain\Model\User\UserRepository');
        $this->specification = new EmailIsUniqueSpecification($this->repository);
    }

    /**
     * @test
     */
    public function isStatisfiedBy_returns_true_is_no_user_found()
    {   
        $email = new Email('unexisting@test.fr');
        $this->repository->shouldReceive('userOfEmail')->once()->with($email)->andReturn(null);
        $this->assertTrue($this->specification->isSatisfiedBy($email));
    }

    /**
     * @test
     */
    public function isStatisfiedBy_returns_false_is_a_user_is_found()
    {
        $email = new Email('existing@test.fr');
        $user = User::register($email);
        $this->repository->shouldReceive('userOfEmail')->once()->with($email)->andReturn($user);
        $this->assertFalse($this->specification->isSatisfiedBy($email));
    }
}