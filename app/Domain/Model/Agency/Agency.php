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

    private $agencyAgentLinks;

    private function __construct(Name $name)
    {
        $this->name              = $name->toNative();
        $this->agencyMarketLinks = new ArrayCollection();
        $this->agencyAgentLinks  = new ArrayCollection();
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
            throw new DomainException(sprintf('Agency %s is already referenced on market %s', $this, $market));
        }

        $this->agencyMarketLinks[] = new AgencyMarketLink($this, $market, $productionManager);
    }

    public function isReferencedOn(Market $market)
    {
        try
        {
            $this->getMarketLink($market);

            return true;
        }
        catch(DomainException $exception)
        {
            return false;
        }

    }

    public function getProductionManager(Market $market)
    {
        return $this->getMarketLink($market)->getProductionManager();
    }

    public function changeProductionManager(Market $market, User $productionManager)
    {
        return $this->getMarketLink($market)->changeProductionManager($productionManager);
    }

    public function isOnlineOn(Market $market)
    {
        return $this->getMarketLink($market)->isOnline();
    }

    public function setOnline(Market $market)
    {
        $this->getMarketLink($market)->setOnline();
    }

    public function setOffline(Market $market)
    {
        $this->getMarketLink($market)->setOffline();
    }

    public function enlistAgent(User $agent, Market $market)
    {
        $this->agencyAgentLinks[] = new AgencyAgentLink($this, $agent, $market);
    }

    public function enlistManager(User $manager, Market $market)
    {
        $agencyAgentLink = new AgencyAgentLink($this, $manager, $market);

        $agencyAgentLink->promoteToManagerRole();

        $this->agencyAgentLinks[] = $agencyAgentLink;
    }

    public function promoteToManager(User $agent, Market $market)
    {
        $this->getAgentLink($agent, $market)->promoteToManagerRole();
    }

    public function downgradeToAgent(User $agent, Market $market)
    {
        $this->getAgentLink($agent, $market)->downgradeToAgentRole();
    }

    public function isAgent(User $user, Market $market)
    {
        try
        {
            $this->getAgentLink($user, $market);

            return true;
        }
        catch(DomainException $e)
        {
            return false;
        }
    }

    public function isManager(User $user, Market $market)
    {
        try
        {
            return $this->getAgentLink($user, $market)->isManager();
        }
        catch(DomainException $e)
        {
            return false;
        }
    }

    private function getMarketLink(Market $market)
    {
        foreach($this->agencyMarketLinks as $agencyMarketLink) {
            if($agencyMarketLink->getMarket() === $market) {
                return $agencyMarketLink;
            }
        }

        throw new DomainException(sprintf('Agency %s is not referenced on market %s', $this, $market));
    }

    private function getAgentLink(User $agent, Market $market)
    {
        foreach($this->agencyAgentLinks as $agencyAgentLink) {
            if($agencyAgentLink->getMarket() === $market && $agencyAgentLink->getAgent() === $agent) {
                return $agencyAgentLink;
            }
        }

        throw new DomainException(sprintf('User %s is not an agent for %s on market %s', $agent, $this, $market));
    }

    public function __toString()
    {
        return $this->name;
    }
}
