<?php

declare(strict_types=1);
namespace App\Entity;

use App\Repository\TypeForfaitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: TypeForfaitRepository::class)]
class TypeForfait
{
	#[ORM\Id]
               	#[ORM\GeneratedValue]
               	#[ORM\Column(type: 'integer')]
               	private $id;

	#[ORM\Column(type: 'string', length: 100)]
               	private $titre;

	#[ORM\Column(type: 'boolean')]
               	private $actif;

	#[ORM\OneToMany(mappedBy: 'type_forfait', targetEntity: Forfait::class, orphanRemoval: true)]
               	private $forfaits;

	#[ORM\Column(type: 'integer', nullable: true)]
               	private $code;

    #[ORM\OneToMany(mappedBy: 'forfaitType', targetEntity: ForfaitTypeTraductions::class, orphanRemoval: true)]
    private $forfaitTypeTraductions;

	public function __construct()
               	{
               		$this->forfaits = new ArrayCollection();
                 $this->forfaitTypeTraductions = new ArrayCollection();
               	}

	public function getId(): ?int
               	{
               		return $this->id;
               	}

	public function getTitre(): ?string
               	{
               		return $this->titre;
               	}

	public function setTitre(string $titre): self
               	{
               		$this->titre = $titre;
               
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

	/**
	 * @return Collection<int, Forfait>
	 */
	public function getForfaits(): Collection
               	{
               		return $this->forfaits;
               	}

	public function addForfait(Forfait $forfait): self
               	{
               		if (!$this->forfaits->contains($forfait)) {
               			$this->forfaits[] = $forfait;
               			$forfait->setTypeForfait($this);
               		}
               
               		return $this;
               	}

	public function removeForfait(Forfait $forfait): self
               	{
               		if ($this->forfaits->removeElement($forfait)) {
               			// set the owning side to null (unless already changed)
               			if ($forfait->getTypeForfait() === $this) {
               				$forfait->setTypeForfait(null);
               			}
               		}
               
               		return $this;
               	}

	public function getCode(): ?int
               	{
               		return $this->code;
               	}

	public function setCode(int $code): self
               	{
               		$this->code = $code;
               
               		return $this;
               	}

    /**
     * @return Collection<int, ForfaitTypeTraductions>
     */
    public function getForfaitTypeTraductions(): Collection
    {
        return $this->forfaitTypeTraductions;
    }

    public function addForfaitTypeTraduction(ForfaitTypeTraductions $forfaitTypeTraduction): self
    {
        if (!$this->forfaitTypeTraductions->contains($forfaitTypeTraduction)) {
            $this->forfaitTypeTraductions[] = $forfaitTypeTraduction;
            $forfaitTypeTraduction->setForfaitType($this);
        }

        return $this;
    }

    public function removeForfaitTypeTraduction(ForfaitTypeTraductions $forfaitTypeTraduction): self
    {
        if ($this->forfaitTypeTraductions->removeElement($forfaitTypeTraduction)) {
            // set the owning side to null (unless already changed)
            if ($forfaitTypeTraduction->getForfaitType() === $this) {
                $forfaitTypeTraduction->setForfaitType(null);
            }
        }

        return $this;
    }

    /**
     * Build formated Type Forfait text
     * @return string
     */
    public function __toString(){
        $titre = $this->getTitre();

        return $titre;
    }
}
