<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
class Prestataire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteInternet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numTva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSiteInternet(): ?string
    {
        return $this->siteInternet;
    }

    public function setSiteInternet(?string $siteInternet): self
    {
        $this->siteInternet = $siteInternet;

        return $this;
    }

    public function getNomTel(): ?string
    {
        return $this->nomTel;
    }

    public function setNomTel(?string $nomTel): self
    {
        $this->nomTel = $nomTel;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->numTva;
    }

    public function setNumTva(?string $numTva): self
    {
        $this->numTva = $numTva;

        return $this;
    }
}
