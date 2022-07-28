<?php

namespace App\Entity;

use App\Repository\CabinTypeElementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CabinTypeElementRepository::class)]
class CabinTypeElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $element;

    #[ORM\Column(type: 'smallint')]
    private $position;

    #[ORM\ManyToOne(targetEntity: CabinType::class, inversedBy: 'elements')]
    private $cabinType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElement(): ?string
    {
        return $this->element;
    }

    public function setElement(?string $element): self
    {
        $this->element = $element;

        return $this;
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

    public function getCabinType(): ?CabinType
    {
        return $this->cabinType;
    }

    public function setCabinType(?CabinType $cabinType): self
    {
        $this->cabinType = $cabinType;

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
}
