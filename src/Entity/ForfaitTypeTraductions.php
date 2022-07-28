<?php

namespace App\Entity;

use App\Repository\ForfaitTypeTraductionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitTypeTraductionsRepository::class)]
class ForfaitTypeTraductions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $lang;

    #[ORM\Column(type: 'string', length: 200)]
    private $forfaitTypeTitle;

    #[ORM\ManyToOne(targetEntity: TypeForfait::class, inversedBy: 'forfaitTypeTraductions')]
    #[ORM\JoinColumn(nullable: false)]
    private $forfaitType;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getForfaitTypeTitle(): ?string
    {
        return $this->forfaitTypeTitle;
    }

    public function setForfaitTypeTitle(string $forfaitTypeTitle): self
    {
        $this->forfaitTypeTitle = $forfaitTypeTitle;

        return $this;
    }

    public function getForfaitType(): ?TypeForfait
    {
        return $this->forfaitType;
    }

    public function setForfaitType(?TypeForfait $forfaitType): self
    {
        $this->forfaitType = $forfaitType;

        return $this;
    }
}
