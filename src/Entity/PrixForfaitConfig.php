<?php

namespace App\Entity;

use App\Repository\PrixForfaitConfigRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrixForfaitConfigRepository::class)]
class PrixForfaitConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tarifSemaine;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tarifJour;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    #[ORM\ManyToOne(targetEntity: ForfaitConfig::class, inversedBy: 'prixForfaitConfigs')]
    #[ORM\JoinColumn(nullable: false)]
    private $forfaitConfig;

    #[ORM\ManyToOne(targetEntity: Forfait::class, inversedBy: 'prixForfaitConfigs')]
    #[ORM\JoinColumn(nullable: false)]
    private $forfait;

    #[ORM\Column(type: 'string', length: 50)]
    private $currency;

    public function __construct()
    {
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifSemaine(): ?int
    {
        return $this->tarifSemaine;
    }

    public function setTarifSemaine(?int $tarifSemaine): self
    {
        $this->tarifSemaine = $tarifSemaine;

        return $this;
    }

    public function getTarifJour(): ?int
    {
        return $this->tarifJour;
    }

    public function setTarifJour(?int $tarifJour): self
    {
        $this->tarifJour = $tarifJour;

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

    public function getForfaitConfig(): ?ForfaitConfig
    {
        return $this->forfaitConfig;
    }

    public function setForfaitConfig(?ForfaitConfig $forfaitConfig): self
    {
        $this->forfaitConfig = $forfaitConfig;

        return $this;
    }

    public function getForfait(): ?Forfait
    {
        return $this->forfait;
    }

    public function setForfait(?Forfait $forfait): self
    {
        $this->forfait = $forfait;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
