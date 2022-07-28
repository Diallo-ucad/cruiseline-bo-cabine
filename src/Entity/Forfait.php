<?php

declare(strict_types=1);
namespace App\Entity;

use App\Repository\ForfaitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitRepository::class)]
class Forfait
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', length: 100, nullable: true)]
	private $forfait_titre;

	#[ORM\Column(type: 'boolean')]
	private $actif;

	#[ORM\ManyToOne(targetEntity: TypeForfait::class, inversedBy: 'forfaits')]
	#[ORM\JoinColumn(nullable: false)]
	private $type_forfait;

	#[ORM\OneToMany(mappedBy: 'forfait', targetEntity: ForfaitContent::class, orphanRemoval: true)]
	private $forfaitContents;

	#[ORM\Column(type: 'string', length: 100, nullable: true)]
	private $type_prestation_id;

	#[ORM\OneToMany(mappedBy: 'forfait', targetEntity: PrixForfaitConfig::class, orphanRemoval: true)]
	private $prixForfaitConfigs;

	#[ORM\Column(type: 'integer')]
	private $companyId;

	#[ORM\OneToMany(mappedBy: 'forfait', targetEntity: ForfaitTraductions::class, orphanRemoval: true)]
	private $forfaitTraductions;

	public function __construct()
	{
		$this->forfaitContents = new ArrayCollection();
		$this->prixForfaitConfigs = new ArrayCollection();
		$this->forfaitTraductions = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getForfaitTitre(): ?string
	{
		return $this->forfait_titre;
	}

	public function setForfaitTitre(?string $forfait_titre): self
	{
		$this->forfait_titre = $forfait_titre;

		return $this;
	}

	public function isActif(): ?bool
	{
		return $this->actif;
	}

	public function setActif(bool $actif): self
	{
		$this->actif = $actif;

		return $this;
	}

	public function getTypeForfait(): ?TypeForfait
	{
		return $this->type_forfait;
	}

	public function setTypeForfait(?TypeForfait $type_forfait): self
	{
		$this->type_forfait = $type_forfait;

		return $this;
	}

	/**
	 * @return Collection<int, ForfaitContent>
	 */
	public function getForfaitContents(): Collection
	{
		return $this->forfaitContents;
	}

	public function addForfaitContent(ForfaitContent $forfaitContent): self
	{
		if (!$this->forfaitContents->contains($forfaitContent)) {
			$this->forfaitContents[] = $forfaitContent;
			$forfaitContent->setForfait($this);
		}

		return $this;
	}

	public function removeForfaitContent(ForfaitContent $forfaitContent): self
	{
		if ($this->forfaitContents->removeElement($forfaitContent)) {
			// set the owning side to null (unless already changed)
			if ($forfaitContent->getForfait() === $this) {
				$forfaitContent->setForfait(null);
			}
		}

		return $this;
	}

	public function getTypePrestationId(): ?string
	{
		return $this->type_prestation_id;
	}

	public function setTypePrestationId(?string $type_prestation_id): self
	{
		$this->type_prestation_id = $type_prestation_id;

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
			$prixForfaitConfig->setForfait($this);
		}

		return $this;
	}

	public function removePrixForfaitConfig(PrixForfaitConfig $prixForfaitConfig): self
	{
		if ($this->prixForfaitConfigs->removeElement($prixForfaitConfig)) {
			// set the owning side to null (unless already changed)
			if ($prixForfaitConfig->getForfait() === $this) {
				$prixForfaitConfig->setForfait(null);
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

	/**
	 * @return Collection<int, ForfaitTraductions>
	 */
	public function getForfaitTraductions(): Collection
	{
		return $this->forfaitTraductions;
	}

	public function addForfaitTraduction(ForfaitTraductions $forfaitTraduction): self
	{
		if (!$this->forfaitTraductions->contains($forfaitTraduction)) {
			$this->forfaitTraductions[] = $forfaitTraduction;
			$forfaitTraduction->setForfait($this);
		}

		return $this;
	}

	public function removeForfaitTraduction(ForfaitTraductions $forfaitTraduction): self
	{
		if ($this->forfaitTraductions->removeElement($forfaitTraduction)) {
			// set the owning side to null (unless already changed)
			if ($forfaitTraduction->getForfait() === $this) {
				$forfaitTraduction->setForfait(null);
			}
		}

		return $this;
	}

    /**
     * Build formated Forfaitconfig text
     * @return string
     */
    public function __toString(){
        $forfaitTitle = $this->getForfaitTitre();
        return $forfaitTitle;
    }

}
