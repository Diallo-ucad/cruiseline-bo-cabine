<?php

declare(strict_types=1);
namespace App\Entity;

use App\Repository\ForfaitContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitContentRepository::class)]
class ForfaitContent
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', length: 50)]
	private $langue;

	#[ORM\Column(type: 'boolean')]
	private $adult_only;

	#[ORM\Column(type: 'integer')]
	private $position;

	#[ORM\Column(type: 'text')]
	private $description;

	#[ORM\ManyToOne(targetEntity: Forfait::class, inversedBy: 'forfaitContents')]
	#[ORM\JoinColumn(nullable: false)]
	private $forfait;


	public function __construct()
	{

	}

	public function getId(): ?int
	{
		return $this->id;
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

	public function isAdultOnly(): ?bool
	{
		return $this->adult_only;
	}

	public function setAdultOnly(bool $adult_only): self
	{
		$this->adult_only = $adult_only;

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


	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

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
