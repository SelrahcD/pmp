<?php
namespace Pmp\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Pmp\Domain\Model\Market\MarketRepository;
use Pmp\Domain\Model\Market\Market;
use Pmp\Domain\Model\Market\Url;

class MarketDoctrineOrmRepository implements MarketRepository
{
    private $em;

    private $class = 'Pmp\Domain\Model\Market\Market';

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(Market $market)
    {
        $this->em->persist($market);
        $this->em->flush();
    }

    public function marketWithUrl(Url $url)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'url' => $url->toNative()
        ]);
    }
}