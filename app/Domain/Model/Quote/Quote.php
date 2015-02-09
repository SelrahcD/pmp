<?php
namespace Pmp\Domain\Model\Quote;

use Doctrine\ORM\Mapping as ORM;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Model\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="quotes")
 */
class Quote {

    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $communication_key;

    /**
     * @ORM\ManyToOne(targetEntity="Pmp\Domain\Model\User\User", inversedBy="quotes")
     **/
    private $customer;

    private function __construct(Key $key, User $customer)
    {
        $this->communication_key = $key->toNative();
        $this->customer          = $customer;
    }

    static public function askForQuote(Key $key, User $customer)
    {
        $quote = new self($key, $customer);

        return $quote;
    }
}
