<?php
namespace Pmp\Domain\Model\Quote\Specifications;

use Pmp\Domain\Model\Quote\QuoteRepository;

class KeyIsUniqueSpecification
{
    private $quoteRepository;
    
    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function isSatisfiedBy($key)
    {
        return $this->quoteRepository->quoteWithKey($key) === null;
    }
}