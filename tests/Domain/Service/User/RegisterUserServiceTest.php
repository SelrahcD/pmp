<?php

use Mockery as m;
use Pmp\Domain\Service\User\RegisterUserService;

class RegisterUserServiceTest extends PHPUnit_Framework_TestCase
{
    private $service;

    private $repository;

    public function setUp()
    {
        $this->repository = m::mock('Pmp\Domain\Model\User\UserRepository');
        $this->service    = new RegisterUserService($this->repository);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function register_throws_InvalidArgumentException_if_email_is_already_taken()
    {
        $this->repository->shouldReceive('userOfEmail')->once()->andReturn(true);
        $user = $this->service->register('toto@test.fr');
    }

    /**
     * @test
     */
    public function register_registers_a_new_user()
    {
        $this->repository->shouldReceive('userOfEmail')->once()->andReturn(null);
        $this->repository->shouldReceive('add')->once();
        $user = $this->service->register('toto@test.fr');
        $this->assertInstanceOf('Pmp\Domain\Model\User\User', $user);
    }
}