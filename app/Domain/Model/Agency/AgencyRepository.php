<?php
namespace Pmp\Domain\Model\Agency;

interface AgencyRepository
{
    public function add(Agency $user);

    public function agencyOfName(Name $name);
}