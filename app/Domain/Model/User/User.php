<?php
namespace Pmp\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Pmp\Core\Events\EventRecorder;
use Pmp\Domain\Model\User\Events\UserRegistered;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {

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
    private $email;

    private function __construct(Email $email)
    {
        $this->email = $email->toNative();
    }

    static public function register(Email $email)
    {
        $user = new self($email);

        $user->recordThat(new UserRegistered($email));

        return $user;
    }
}
