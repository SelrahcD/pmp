<?php
namespace Pmp\Domain\Market;

use Pmp\Core\Domain\DomainUrl;

class Market
{
    private $id;

    private $domainName;

    public function __construct($id, DomainUrl $domainUrl)
    {
        $this->id = $id;
        $this->domainUrl = $domainUrl;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getDomainUrl()
    {
        return $this->domainUrl;
    }
}