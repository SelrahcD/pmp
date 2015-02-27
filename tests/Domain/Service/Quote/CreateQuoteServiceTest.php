<?php

use Mockery as m;
use Pmp\Domain\Service\Quote\CreateQuoteService;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Domain\Model\Agency\Agency;

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
        $market = new Market(new Url('http://poney.fr'));
        $agency = Agency::referenceAgency('BZHTour');
        $quote = $this->service->createQuoteForMember($user, $market, $agency);

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

        $market = new Market(new Url('http://poney.fr'));
        $agency = Agency::referenceAgency('BZHTour');
        $quote = $this->service->createQuoteForGuest('poney@poney.fr', $market, $agency);

        $this->assertInstanceOf('Pmp\Domain\Model\Quote\Quote', $quote);
    }
}