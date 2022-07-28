<?php

namespace App\Entity;

use App\Repository\CabinCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CabinCategoryRepository::class)]
class CabinCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint')]
    private $compagnie_id;

    #[ORM\Column(type: 'smallint', length: 5)]
    private $CabinCategoryCode;

    #[ORM\OneToMany(mappedBy: 'CabinCategory', targetEntity: CabinType::class, cascade: ["all"], orphanRemoval: true)]
    #[ORM\OrderBy(['position'=>'ASC'])]
    private $cabinTypes;

    #[ORM\Column(type: 'string', length: 4)]
    private $langue;

    #[ORM\Column(type: 'string')]
    private $bateauId;

    #[ORM\Column(type: 'string', length: 50)]
    private $cabinCategoryTexte;

    #[ORM\OneToMany(mappedBy: 'cabinCategory', targetEntity: ForfaitConfig::class, orphanRemoval: true)]
    private $forfaitConfigs;




    public function __construct()
    {
        $this->cabinTypes = new ArrayCollection();
        $this->forfaitConfigs = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCompagnieId(): ?int
    {
        return $this->compagnie_id;
    }

    public function setCompagnieId(int $compagnie_id): self
    {
        $this->compagnie_id = $compagnie_id;

        return $this;
    }

    public function getCabinCategoryCode(): ?string
    {
        return $this->CabinCategoryCode;
    }

    public function setCabinCategoryCode(string $CabinCategoryCode): self
    {
        $this->CabinCategoryCode = $CabinCategoryCode;

        return $this;
    }

    public function getCabinCategoryInt(): ?int
    {
        return $this->CabinCategoryInt;
    }

    public function setCabinCategoryInt(int $CabinCategoryInt): self
    {
        $this->CabinCategoryInt = $CabinCategoryInt;

        return $this;
    }

    /**
     * @return Collection<int, CabinType>
     */
    public function getCabinTypes(): Collection
    {
        return $this->cabinTypes;
    }

    public function addCabinType(CabinType $cabinType): self
    {
        if (!$this->cabinTypes->contains($cabinType)) {
            $this->cabinTypes[] = $cabinType;
            $cabinType->setCabinCategory($this);
        }

        return $this;
    }

    public function removeCabinType(CabinType $cabinType): self
    {
        if ($this->cabinTypes->removeElement($cabinType)) {
            // set the owning side to null (unless already changed)
            if ($cabinType->getCabinCategory() === $this) {
                $cabinType->setCabinCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->CabinCategoryCode;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getBateauId(): ?string
    {
        return $this->bateauId;
    }

    public function setBateauId(string $bateauId): self
    {
        $this->bateauId = $bateauId;

        return $this;
    }

    public function getCabinCategoryTexte(): ?string
    {
        return $this->cabinCategoryTexte;
    }

    public function setCabinCategoryTexte(string $cabinCategoryTexte): self
    {
        $this->cabinCategoryTexte = $cabinCategoryTexte;

        return $this;
    }

    /**
     * @return Collection<int, ForfaitConfig>
     */
    public function getForfaitConfigs(): Collection
    {
        return $this->forfaitConfigs;
    }

    public function addForfaitConfig(ForfaitConfig $forfaitConfig): self
    {
        if (!$this->forfaitConfigs->contains($forfaitConfig)) {
            $this->forfaitConfigs[] = $forfaitConfig;
            $forfaitConfig->setCabinCategory($this);
        }

        return $this;
    }

    public function removeForfaitConfig(ForfaitConfig $forfaitConfig): self
    {
        if ($this->forfaitConfigs->removeElement($forfaitConfig)) {
            // set the owning side to null (unless already changed)
            if ($forfaitConfig->getCabinCategory() === $this) {
                $forfaitConfig->setCabinCategory(null);
            }
        }

        return $this;
    }

}
