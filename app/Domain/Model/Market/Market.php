<?php
namespace Pmp\Domain\Model\Market;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="market")
 */
class Market {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url->toNative();
    }

    public function __toString()
    {
        return $this->url;
    }
}
