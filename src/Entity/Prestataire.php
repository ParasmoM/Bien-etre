<?php

namespace App\Entity;

use App\Entity\Trait\ToStringCompletTrait;
use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
/**
 * @ORM\Table(name="Prestataire",indexes={@ORM\Index(columns={"nom"}, flags={"fulltext"})})
 */

class Prestataire
{
    use ToStringCompletTrait;

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

    #[ORM\OneToMany(mappedBy: 'prestataire', targetEntity: Utilisateur::class)]
    private Collection $utilisateurs;

    #[ORM\OneToMany(mappedBy: 'prestataire', targetEntity: Images::class, cascade: ['persist'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Promotion::class, inversedBy: 'prestataires', cascade: ['persist'])]
    private Collection $promotion;

    #[ORM\ManyToMany(targetEntity: Stage::class, inversedBy: 'prestataires', cascade: ['persist'])]
    private Collection $stage;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->promotion = new ArrayCollection();
        $this->stage = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setPrestataire($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getPrestataire() === $this) {
                $utilisateur->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPrestataire($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPrestataire() === $this) {
                $image->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion->add($promotion);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        $this->promotion->removeElement($promotion);

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stage->contains($stage)) {
            $this->stage->add($stage);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        $this->stage->removeElement($stage);

        return $this;
    }
}
