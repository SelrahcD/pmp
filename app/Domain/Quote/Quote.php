<?php
namespace Pmp\Domain\Quote;

use Pmp\Core\Uuid\Uuid;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Market\MarketSpecificData;
use Pmp\Domain\Market\Market;
use Pmp\Domain\Quote\Events\QuoteCreated;
use Buttercup\Protects\RecordsEvents;
use Pmp\Domain\Farm\Farm;

class Quote implements RecordsEvents
{    
    use Uuid;
    use EventRecorder;

    private $id;

    private $market;

    private $farm;

    private function __construct($id, Market $market, Farm $farm)
    {
        if(!$farm->canRespondToDemandOnMarket($market))
        {
            die('AAAA');
        }

        $this->id     = $id;
        $this->market = $market;
        $this->farm    = $farm;
    }

    static public function startQuote(Market $market, Farm $farm)
    {
        $quote = new self(self::generateUuid(), $market, $farm);

        $quote->recordThat(new QuoteCreated($quote->getId(), $market->getId(), $farm->getId()));

        return $quote;
    }

    public function getId()
    {
        return $this->id;
    }
}