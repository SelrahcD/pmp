<?php namespace Pmp\Http\Controllers;

use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\User\UserRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Quote\Key;

class TestController extends Controller {

    public function index(RegisterUserService $registerUserService, UserRepository $userRepository, QuoteRepository $quoteRepository)
    {
        // $user = User::register(new Email('toto@test.fr'));
        // $userRepository->add($user);
        // dd();
        $user = $userRepository->userOfEmail(new Email('toto@test.fr'));

        // $quote = Quote::askForQuote(Key::generate(), $user);
        // $quoteRepository->add($quote);
        $quote = $quoteRepository->quoteWithKey(new Key('12345'));
        dd($quote);
        dd($user);
    }

}
