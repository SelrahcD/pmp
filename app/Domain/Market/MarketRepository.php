<?php
namespace Pmp\Domain\Market;

use Pmp\Domain\Market\Exceptions\CurrentMarketNotSettedException;
use Pmp\Domain\Market\Exceptions\NoMarketFoundForDomainUrl;
use Pmp\Core\Domain\DomainUrl;

class MarketRepository
{
    private $markets;

    private $currentMarket;

    public function __construct(array $markets)
    {
        $this->markets = $markets;
    }
    
    public function getCurrentMarket()
    {
        if(!$this->currentMarket){
            throw new CurrentMarketNotSettedException;
        }

        return $this->currentMarket;
    }

    public function setCurrentMarketUsingDomainName(DomainUrl $domainUrl)
    {
        foreach($this->markets as $market) {
            if($market->getDomainUrl()->equals($domainUrl)) {
                $this->currentMarket = $market;
                return;
            }
        }

        throw new NoMarketFoundForDomainUrl($domainUrl);
    }
}