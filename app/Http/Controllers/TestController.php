<?php namespace Pmp\Http\Controllers;

use Pmp\Domain\Quote\Quote;
use Pmp\Domain\Market\MarketRepository;
use Pmp\Domain\Market\Market;
use Pmp\Core\Domain\DomainUrl;
use Pmp\Domain\Farm\Farm;

class TestController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $market1 = new Market(1, new DomainUrl('http://pmp.fr'));
        $market2 = new Market(2, new DomainUrl('http://pmp.es'));

        $markets = [1 => $market1,
                    2 => $market2];

        $marketRepo = new MarketRepository($markets);
        $marketRepo->setCurrentMarketUsingDomainName(new DomainUrl('http://pmp.fra'));

        $farm = new Farm(1, 'Le Poney Club de Folie');

        $currentMarket = $marketRepo->getCurrentMarket();

        $quote = Quote::startQuote($currentMarket, $farm);
        dd($quote);
    }

}
