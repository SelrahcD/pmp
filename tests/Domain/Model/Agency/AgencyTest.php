<?php

use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Domain\Model\User\User;
use Pmp\Domain\Model\User\Email;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;


class AgencyTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->agency = new Agency(new Name('Poney'));
        $this->produtionManager1 = User::register(new Email('prod@poney.fr'));
        $this->produtionManager2 = User::register(new Email('prod@poney.fr'));
        $this->market = new Market(new Url('http://market1.fr'));
    }

    /**
     * @test
     */
    public function __toString_returns_Agency_name()
    {
        $this->assertEquals('Poney', $this->agency->__toString());
    }

    /**
     * @test
     * @expectedException DomainException
     */
    public function prospect_throws_DomainException_if_agency_already_referenced_on_market()
    {
        $this->agency->prospect($this->market, $this->produtionManager1);
        $this->agency->prospect($this->market, $this->produtionManager1);
    }

    /**
     * @test
     */
    public function prospect_reference_agency_on_market()
    {
        $this->agency->prospect($this->market, $this->produtionManager1);
        $this->assertTrue($this->agency->isReferencedOn($this->market));
    }

    /**
     * @test
     */
    public function isReferencedOn_returns_true_if_agency_is_referenced_on_market()
    {
        $this->agency->prospect($this->market, $this->produtionManager1);
        $this->assertTrue($this->agency->isReferencedOn($this->market));
    }

    /**
     * @test
     */
    public function isReferencedOn_returns_false_if_agency_is_not_referenced_on_market()
    {
       $this->assertFalse($this->agency->isReferencedOn($this->market)); 
    }

    /**
     * @test
     */
    public function getProductionManager_returns_production_manager_if_agency_is_referenced_on_market()
    {
        $this->agency->prospect($this->market, $this->produtionManager1);
        $this->assertEquals($this->produtionManager1, $this->agency->getProductionManager($this->market));
    }

    /**
     * @test
     * @expectedException DomainException
     */
    public function getProductionManager_throws_DomainException_if_agency_is_not_referenced_on_market()
    {
        $this->agency->getProductionManager($this->market);
    }

    /**
     * @test
     */
    public function changeProductionManager_changes_production_manager()
    {
        $this->agency->prospect($this->market, $this->produtionManager1);
        $this->agency->changeProductionManager($this->market, $this->produtionManager2);
        $this->assertTrue($this->produtionManager2 === $this->agency->getProductionManager($this->market));
        $this->assertFalse($this->produtionManager1 === $this->agency->getProductionManager($this->market));
    }

    /**
     * @test
     * @expectedException DomainException
     */
    public function changeProductionManager_throws_DomainException_ig_agency_is_not_referenced_on_market()
    {
        $this->agency->changeProductionManager($this->market, $this->produtionManager2);
    }


}