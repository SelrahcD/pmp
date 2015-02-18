<?php namespace Pmp\Http\Controllers;

use Pmp\Domain\Service\User\RegisterUserService;
use Pmp\Domain\Model\User\UserRepository;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Quote\Key;
use Pmp\Domain\Model\Market\MarketRepository;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;
use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\Agency\AgencyRepository;

class TestController extends Controller {

    public function index(AgencyRepository $agencyRepo, UserRepository $userRepo, MarketRepository $marketRepo)
    {

        $a = $agencyRepo->agencyOfName(new Name('Poney'));
        $u = $userRepo->userofEmail(new Email('test@test.fr'));
        $m = $marketRepo->marketWithUrl(new Url('http://market.fr'));

        // var_dump($a->isReferencedOn($m));
        // var_dump($a->getProductionManager($m));
        // $a->prospect($m, $u);
        // $agencyRepo->add($a);
        
        dd($a);
    }

}
