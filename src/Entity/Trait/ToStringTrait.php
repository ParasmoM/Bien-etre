<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait ToStringTrait
{
    public function __toString()
    {
        return $this->nom;
    }
}
