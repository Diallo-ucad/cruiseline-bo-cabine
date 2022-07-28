<?php

namespace App\Entity;

use App\Repository\ForfaitTraductionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitTraductionsRepository::class)]
class ForfaitTraductions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $lang;

    #[ORM\Column(type: 'string', length: 200)]
    private $forfaitTitle;

    #[ORM\ManyToOne(targetEntity: Forfait::class, inversedBy: 'forfaitTraductions')]
    #[ORM\JoinColumn(nullable: false)]
    private $forfait;

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

    public function getForfaitTitle(): ?string
    {
        return $this->forfaitTitle;
    }

    public function setForfaitTitle(string $forfaitTitle): self
    {
        $this->forfaitTitle = $forfaitTitle;

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
}
