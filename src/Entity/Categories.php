<?php

namespace App\Entity;

use App\Entity\Trait\ToStringTrait;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    use ToStringTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enAvant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $valide = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Images::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Promotion::class)]
    private Collection $promotions;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->promotions = new ArrayCollection();
    }

    public function getDescriptionTronquee(int $longueur): string
    {
        $description = $this->getDescription();
        if (mb_strlen($description) > $longueur) {
            $description = mb_substr($description, 0, $longueur - 3) . '...';
        }
        return $description;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isEnAvant(): ?bool
    {
        return $this->enAvant;
    }

    public function setEnAvant(?bool $enAvant): self
    {
        $this->enAvant = $enAvant;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

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
            $image->setCategorie($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCategorie() === $this) {
                $image->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
            $promotion->setCategorie($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getCategorie() === $this) {
                $promotion->setCategorie(null);
            }
        }

        return $this;
    }
}
