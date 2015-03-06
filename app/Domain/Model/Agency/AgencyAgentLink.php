<?php
namespace Pmp\Domain\Model\Agency;

use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\User\User;

class AgencyAgentLink {

    const ROLE_AGENT = 0;
    const ROLE_MANAGER = 1;

    private $agency;

    private $agent;

    private $market;

    private $role = self::ROLE_AGENT;

    public function __construct(Agency $agency, User $agent, Market $market)
    {
        $this->agency = $agency;
        $this->agent  = $agent;
        $this->market = $market;
    }

    public function promoteToManagerRole()
    {
        $this->role = self::ROLE_MANAGER;
    }

    public function downgradeToAgentRole()
    {
        $this->role = self::ROLE_AGENT;
    }

    public function getAgent()
    {
        return $this->agent;
    }
    
    public function getMarket()
    {
        return $this->market;
    }
}