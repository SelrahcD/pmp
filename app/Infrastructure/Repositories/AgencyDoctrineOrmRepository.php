<?php
namespace Pmp\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Pmp\Domain\Model\Agency\AgencyRepository;
use Pmp\Domain\Model\Agency\Agency;
use Pmp\Domain\Model\Agency\Name;
use Pmp\Infrastructure\Annotations\Loggable;

class AgencyDoctrineOrmRepository implements AgencyRepository
{
    private $em;

    private $class = 'Pmp\Domain\Model\Agency\Agency';

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(Agency $agency)
    {
        $this->em->persist($agency);
        $this->em->flush();
    }

    /**
     * @Loggable
     */
    public function agencyOfName(Name $name)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'name' => $name->toNative()
        ]);
    }
}