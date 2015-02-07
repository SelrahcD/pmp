<?php
namespace Pmp\Domain\Market\Exceptions;

use Pmp\Core\Domain\DomainUrl;

class NoMarketFoundForDomainUrl extends \Exception
{
    public function __construct(DomainUrl $domainUrl)
    {
        $this->message = sprintf('We were unable to find a market for %s', $domainUrl->getUrl());
    }
}