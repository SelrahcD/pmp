<?php
namespace Pmp\Domain\Farm\Specifications;

use Pmp\Domain\Farm\Farm;

class FarmSpecification
{
    public function isSatisfiedBy(Farm $farm);
}