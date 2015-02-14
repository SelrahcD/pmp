<?php
namespace Pmp\Domain\Model\Agency;

use Doctrine\ORM\Mapping as ORM;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="agency_market_links")
 */
class AgencyMarketLink {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Agency\Agency", inversedBy="agencies")
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\Market\Market", inversedBy="markets")
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="users")
     */
    private $productionManager;

    public function __construct(Agency $agency, Market $market, User $productionManager)
    {
        $this->agency            = $agency;
        $this->market            = $market;
        $this->productionManager = $productionManager;
    }

    public function getMarket()
    {
        return $this->market;
    }

    public function getProductionManager()
    {
        return $this->productionManager;
    }
}
