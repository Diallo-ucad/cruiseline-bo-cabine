<?php

declare(strict_types=1);
namespace App\Entity;

use App\Repository\ForfaitConfigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitConfigRepository::class)]
class ForfaitConfig
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'integer')]
	private $bateau_id;

	#[ORM\Column(type: 'integer')]
	private $port_id;

	#[ORM\OneToMany(mappedBy: 'forfaitConfig', targetEntity: PrixForfaitConfig::class, orphanRemoval: true)]
	private $prixForfaitConfigs;

	#[ORM\Column(type: 'integer')]
	private $companyId;

	#[ORM\ManyToOne(targetEntity: CabinCategory::class, inversedBy: 'forfaitConfigs')]
	#[ORM\JoinColumn(nullable: false)]
	private $cabinCategory;

	#[ORM\ManyToOne(targetEntity: CabinType::class, inversedBy: 'forfaitConfigs')]
	#[ORM\JoinColumn(nullable: false)]
	private $cabinType;


	public function __construct()
	{
		$this->prixForfaitConfigs = new ArrayCollection();
		$this->typePrice = new ArrayCollection();
        return $this;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getBateauId(): ?int
	{
		return $this->bateau_id;
	}

	public function setBateauId(int $bateau_id): self
	{
		$this->bateau_id = $bateau_id;

		return $this;
	}

	public function getPortId(): ?int
	{
		return $this->port_id;
	}

	public function setPortId(int $port_id): self
	{
		$this->port_id = $port_id;

		return $this;
	}

	/**
	 * @return Collection<int, PrixForfaitConfig>
	 */
	public function getPrixForfaitConfigs(): Collection
	{
		return $this->prixForfaitConfigs;
	}

	public function addPrixForfaitConfig(PrixForfaitConfig $prixForfaitConfig): self
	{
		if (!$this->prixForfaitConfigs->contains($prixForfaitConfig)) {
			$this->prixForfaitConfigs[] = $prixForfaitConfig;
			$prixForfaitConfig->setForfaitConfig($this);
		}

		return $this;
	}

	public function removePrixForfaitConfig(PrixForfaitConfig $prixForfaitConfig): self
	{
		if ($this->prixForfaitConfigs->removeElement($prixForfaitConfig)) {
			// set the owning side to null (unless already changed)
			if ($prixForfaitConfig->getForfaitConfig() === $this) {
				$prixForfaitConfig->setForfaitConfig(null);
			}
		}

		return $this;
	}

	public function getCompanyId(): ?int
	{
		return $this->companyId;
	}

	public function setCompanyId(int $companyId): self
	{
		$this->companyId = $companyId;

		return $this;
	}

	public function getCabinCategory(): ?CabinCategory
	{
		return $this->cabinCategory;
	}

	public function setCabinCategory(?CabinCategory $cabinCategory): self
	{
		$this->cabinCategory = $cabinCategory;

		return $this;
	}

	public function getCabinType(): ?CabinType
	{
		return $this->cabinType;
	}

	public function setCabinType(?CabinType $cabinType): self
	{
		$this->cabinType = $cabinType;

		return $this;
	}

    /**
     * Build formated Forfaitconfig text
     * @return string
     */
    public function __toString(){
        $boatId = $this->getBateauId();
        $companyId = $this->getCompanyId();
        $portId = $this->getPortId();
        $categoryCabin = $this->getCabinCategory()->getCabinCategoryTexte();
        $cabinType = $this->getCabinType()->getName();

        $forfaitConfig = "Bateau: $boatId | Compagnie: $companyId | $categoryCabin | $cabinType";
        return $forfaitConfig;
    }


}
