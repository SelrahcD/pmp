<?php
namespace Pmp\Domain\Service\Quote;

use Pmp\Domain\Model\Quote\Specifications\KeyIsUniqueSpecification;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Market\Market;

class CreateQuoteService
{
    private $quoteRepository;

    private $registerUserService;

    public function __construct(QuoteRepository $quoteRepository, RegisterUserService $registerUserService)
    {
        $this->quoteRepository = $quoteRepository;
        $this->registerUserService  = $registerUserService;
    }

    public function createQuoteForMember(User $member, Market $market)
    {
        return $this->createAndSaveQuote($member, $market);
    }

    public function createQuoteForGuest($email, Market $market)
    {
        $user = $this->registerUserService->register($email);

        return $this->createAndSaveQuote($user, $market);
    }

    private function createAndSaveQuote(User $user, Market $market)
    {
        $quote = Quote::createFromScratch($this->getValidQuoteKey(), $user, $market);

        $this->quoteRepository->add($quote);

        return $quote;
    }

    private function getValidQuoteKey()
    {
        $specification = new KeyIsUniqueSpecification($this->quoteRepository);

        do {
            $key = Key::generate();
        } while(!$specification->isSatisfiedBy($key));

        return $key;
    }
}