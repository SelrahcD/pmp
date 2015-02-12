<?php
namespace Pmp\Domain\Service\Quote;

use Pmp\Domain\Model\Quote\Specifications\KeyIsUniqueSpecification;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Quote\Quote;

class CreateQuoteService
{
    private $quoteRepository;

    private $registerUserService;

    public function __construct(QuoteRepository $quoteRepository, RegisterUserService $registerUserService)
    {
        $this->quoteRepository = $quoteRepository;
        $this->registerUserService  = $registerUserService;
    }

    public function createQuoteForMember(User $member)
    {
        return $this->createAndSaveQuote($member);
    }

    public function createQuoteForGuest($email)
    {
        $user = $this->registerUserService->register($email);

        return $this->createAndSaveQuote($user);
    }

    private function createAndSaveQuote(User $user)
    {
        $quote = new Quote($this->getValidQuoteKey(), $user);

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