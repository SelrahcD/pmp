<?php
namespace Pmp\Domain\Model\Agency\Events;

use Pmp\Domain\Model\Agency\Name;

class NewAgencyReferencedEvent
{
    private $name;

    public function __construct(Name $name)
    {
        $this->name = $name->toNative();
    }

    public function getName()
    {
        return Name::fromNative($this->name);
    }
}