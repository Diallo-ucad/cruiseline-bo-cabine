<?php

namespace App\Entity;

use App\Repository\CabinTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CabinTypeRepository::class)]
class CabinType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: CabinCategory::class, inversedBy: 'cabinTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private $CabinCategory;

    #[ORM\Column(type: 'string', length: 60)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'cabinType',cascade :["all"], targetEntity: CabinTypeElement::class)]
    #[ORM\OrderBy(['position'=>'ASC'])]
    private $elements;

    #[ORM\OneToMany(mappedBy: 'cabinType',cascade: ["all"], targetEntity: CabinTypeCode::class)]
    private $codes;

    #[ORM\Column(type: 'smallint')]
    private $position;

    #[ORM\ManyToMany(targetEntity: TypePrice::class)]
    private $TypesPrices;

    #[ORM\OneToMany(mappedBy: 'cabinTypeId', targetEntity: ForfaitConfig::class)]
    private $fofaitConfigs;

    #[ORM\OneToMany(mappedBy: 'cabinType', targetEntity: ForfaitConfig::class, orphanRemoval: true)]
    private $forfaitConfigs;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
        $this->codes = new ArrayCollection();
        $this->TypesPrices = new ArrayCollection();
        $this->forfaitConfigs = new ArrayCollection();
        $this->forfaitConfigs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCabinCategory(): ?CabinCategory
    {
        return $this->CabinCategory;
    }

    public function setCabinCategory(?CabinCategory $CabinCategory): self
    {
        $this->CabinCategory = $CabinCategory;

        return $this;
    }

    public function getBateauId(): ?int
    {
        return $this->bateau_id;
    }

    public function setBateauId(?int $bateau_id): self
    {
        $this->bateau_id = $bateau_id;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CabinTypeElement>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(CabinTypeElement $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements[] = $element;
            $element->setCabinType($this);
        }

        return $this;
    }

    public function removeElement(CabinTypeElement $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getCabinType() === $this) {
                $element->setCabinType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CabinTypeCode>
     */
    public function getCodes(): Collection
    {
        return $this->codes;
    }

    public function addCode(CabinTypeCode $code): self
    {
        if (!$this->codes->contains($code)) {
            $this->codes[] = $code;
            $code->setCabinType($this);
        }

        return $this;
    }

    public function removeCode(CabinTypeCode $code): self
    {
        if ($this->codes->removeElement($code)) {
            // set the owning side to null (unless already changed)
            if ($code->getCabinType() === $this) {
                $code->setCabinType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, TypePrice>
     */
    public function getTypesPrices(): Collection
    {
        return $this->TypesPrices;
    }

    public function addTypesPrice(TypePrice $typesPrice): self
    {
        if (!$this->TypesPrices->contains($typesPrice)) {
            $this->TypesPrices[] = $typesPrice;
        }

        return $this;
    }

    public function removeTypesPrice(TypePrice $typesPrice): self
    {
        $this->TypesPrices->removeElement($typesPrice);

        return $this;
    }

    /**
     * @return Collection<int, ForfaitConfig>
     */
    public function getFofaitConfigs(): Collection
    {
        return $this->fofaitConfigs;
    }

    public function addFofaitConfig(ForfaitConfig $fofaitConfig): self
    {
        if (!$this->fofaitConfigs->contains($fofaitConfig)) {
            $this->fofaitConfigs[] = $fofaitConfig;
            $fofaitConfig->setCabinTypeId($this);
        }

        return $this;
    }

    public function removeFofaitConfig(ForfaitConfig $fofaitConfig): self
    {
        if ($this->fofaitConfigs->removeElement($fofaitConfig)) {
            // set the owning side to null (unless already changed)
            if ($fofaitConfig->getCabinTypeId() === $this) {
                $fofaitConfig->setCabinTypeId(null);
            }
        }

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
            $forfaitConfig->setCabinType($this);
        }

        return $this;
    }

    public function removeForfaitConfig(ForfaitConfig $forfaitConfig): self
    {
        if ($this->forfaitConfigs->removeElement($forfaitConfig)) {
            // set the owning side to null (unless already changed)
            if ($forfaitConfig->getCabinType() === $this) {
                $forfaitConfig->setCabinType(null);
            }
        }

        return $this;
    }
}
