<?php
namespace Pmp\Domain\Service\Quote;

use Pmp\Domain\Model\Quote\Specifications\KeyIsUniqueSpecification;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Agency\Agency;

class CreateQuoteService
{
    private $quoteRepository;

    private $registerUserService;

    public function __construct(QuoteRepository $quoteRepository, RegisterUserService $registerUserService)
    {
        $this->quoteRepository = $quoteRepository;
        $this->registerUserService  = $registerUserService;
    }

    public function createQuoteForMember(User $member, Market $market, Agency $agency)
    {
        return $this->createAndSaveQuote($member, $market, $agency);
    }

    public function createQuoteForGuest($email, Market $market, Agency $agency)
    {
        $user = $this->registerUserService->register($email);

        return $this->createAndSaveQuote($user, $market, $agency);
    }

    private function createAndSaveQuote(User $user, Market $market, Agency $agency)
    {
        $quote = Quote::createFromScratch($this->getValidQuoteKey(), $user, $market, $agency);

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