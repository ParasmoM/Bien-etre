<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait ToStringCompletTrait
{
    public function __toString()
    {
        return $this->nom . ' ' . $this->prenom;
    }
}