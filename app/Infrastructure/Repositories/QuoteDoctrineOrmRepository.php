<?php
namespace Pmp\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Pmp\Domain\Model\Quote\QuoteRepository;
use Pmp\Domain\Model\Quote\Quote;
use Pmp\Domain\Model\Quote\Key;

class QuoteDoctrineOrmRepository implements QuoteRepository
{
    private $em;

    private $class = 'Pmp\Domain\Model\Quote\Quote';

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(Quote $quote)
    {
        $this->em->persist($quote);
        $this->em->flush();
    }

    public function quoteWithKey(Key $key)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'communication_key' => $key->toNative()
        ]);
    }
}