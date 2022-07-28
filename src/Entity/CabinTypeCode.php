<?php

namespace App\Entity;

use App\Repository\CabinTypeCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CabinTypeCodeRepository::class)]
class CabinTypeCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 5)]
    private $code;

    #[ORM\ManyToOne(targetEntity: CabinType::class, inversedBy: 'codes')]
    private $cabinType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
}
