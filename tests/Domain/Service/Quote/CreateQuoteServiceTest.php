<?php

use Mockery as m;
use Pmp\Domain\Service\Quote\CreateQuoteService;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;

class CreateQuoteServiceTest extends PHPUnit_Framework_TestCase
{
    private $service;

    private $repository;

    private $registerUserService;

    public function setUp()
    {
        $this->repository = m::mock('Pmp\Domain\Model\Quote\QuoteRepository');
        $this->registerUserService = m::mock('Pmp\Domain\Service\User\RegisterUserService');
        $this->service  = new CreateQuoteService($this->repository, $this->registerUserService);
    }

    /**
     * @test
     */
    public function createQuoteForMember_returns_a_Quote()
    {
        $this->repository->shouldReceive('quoteWithKey')->once()->andReturn(null);
        $this->repository->shouldReceive('add')->once()->andReturn(null);

        $user = User::register(new Email('poney@poney.fr'));
        $quote = $this->service->createQuoteForMember($user);

        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
    }

    /**
     * @test
     */
    public function createQuoteForGuest_returns_a_Quote()
    {
        $this->repository->shouldReceive('quoteWithKey')->once()->andReturn(null);
        $this->repository->shouldReceive('add')->once()->andReturn(null);
        $this->registerUserService->shouldReceive('register')->once()->with('poney@poney.fr')->andReturn(User::register(new Email('poney@poney.fr')));

        $quote = $this->service->createQuoteForGuest('poney@poney.fr');

        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
    }
}