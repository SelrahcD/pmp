<?php
namespace Pmp\Domain\Model\Agency;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\Market\Market;
use DomainException;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Model\Agency\Events\NewAgencyReferencedEvent;

/**
 * @ORM\Entity
 * @ORM\Table(name="agencies")
 */
class Agency {

    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Pmp\Domain\Model\Agency\AgencyMarketLink", mappedBy="agency", cascade={"persist", "remove"})
     */
    private $agencyMarketLinks;

    private function __construct(Name $name)
    {
        $this->name              = $name->toNative();
        $this->agencyMarketLinks = new ArrayCollection();
    }

    static public function referenceAgency($name)
    {
        $name = new Name($name);

        $agence = new self($name);

        $agence->recordThat(new NewAgencyReferencedEvent($name));

        return $agence;
    }

    public function prospect(Market $market, User $productionManager)
    {
        if($this->isReferencedOn($market)) {
            throw new DomainException(sprintf('Agency %s already referenced on market %s', $this, $market));
        }

        $this->agencyMarketLinks[] = new AgencyMarketLink($this, $market, $productionManager);
    }

    public function isReferencedOn(Market $market)
    {
        foreach($this->agencyMarketLinks as $agencyMarketLink) {
            if($agencyMarketLink->getMarket() === $market) {
                return true;
            }
        }

        return false;
    }

    public function getProductionManager(Market $market)
    {
        foreach($this->agencyMarketLinks as $agencyMarketLink) {
            if($agencyMarketLink->getMarket() === $market) {
                return $agencyMarketLink->getProductionManager();
            }
        }

        throw new DomainException(sprintf('Agency %s is not referenced on marker %s', $this, $market));
    }

    public function changeProductionManager(Market $market, User $productionManager)
    {
        foreach($this->agencyMarketLinks as $agencyMarketLink) {
            if($agencyMarketLink->getMarket() === $market) {
                return $agencyMarketLink->changeProductionManager($productionManager);
            }
        }

        throw new DomainException(sprintf('Agency %s is not referenced on marker %s', $this, $market));
   
    }

    public function __toString()
    {
        return $this->name;
    }
}
