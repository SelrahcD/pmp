<?php
namespace Pmp\Domain\Model\Market;

interface MarketRepository
{
    public function marketWithUrl(Url $url);

    public function add(Market $market);
}