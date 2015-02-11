<?php

use Mockery as m;
use Pmp\Domain\Model\Quote\Specifications\KeyIsUniqueSpecification;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Model\Quote\Quote;

class QuoteIsUniqueSpecificationTest extends PHPUnit_Framework_TestCase
{
    private $specification;

    private $repository;

    public function setUp()
    {
        $this->repository = m::mock('Pmp\Domain\Model\Quote\QuoteRepository');
        $this->specification = new KeyIsUniqueSpecification($this->repository);
    }

    /**
     * @test
     */
    public function isStatisfiedBy_returns_true_is_no_quote_found()
    {   
        $key = new Key('poney');
        $this->repository->shouldReceive('quoteWithKey')->once()->with($key)->andReturn(null);
        $this->assertTrue($this->specification->isSatisfiedBy($key));
    }

    /**
     * @test
     */
    public function isStatisfiedBy_returns_false_is_a_quote_is_found()
    {
        $key = new Key('poney');
        $this->repository->shouldReceive('quoteWithKey')->once()->with($key)->andReturn(true);
        $this->assertFalse($this->specification->isSatisfiedBy($key));
    }
}