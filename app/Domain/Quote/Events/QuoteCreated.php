<?php
namespace Pmp\Domain\Quote\Events;

use Buttercup\Protects\DomainEvent;

final class QuoteCreated implements DomainEvent
{
    private $quoteId;

    private $marketId;

    private $farmId;

    public function __construct($quoteId, $marketId, $farmId)
    {
        $this->quoteId  = $quoteId;
        $this->marketId = $marketId;
        $this->farmId   = $farmId;
    }

    public function getAggregateId()
    {
        return $this->quoteId;
    }

    public function getMarketId()
    {
        return $this->marketId;
    }

    public function farmId()
    {
        return $this->farmId;
    }
}