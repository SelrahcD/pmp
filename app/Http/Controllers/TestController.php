<?php namespace Pmp\Http\Controllers;

use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\User\UserRepository;
use Pmp\Domain\Model\User\Email;

class TestController extends Controller {

    public function index(RegisterUserService $registerUserService, UserRepository $userRepository)
    {
        $user = $userRepository->userOfEmail(new Email('toto@teaast.fr'));
        dd($user);
    }

}
