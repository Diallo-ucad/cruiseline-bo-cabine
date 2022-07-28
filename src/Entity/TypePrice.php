<?php

declare(strict_types=1);
namespace App\Entity;

use App\Repository\TypePriceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePriceRepository::class)]
class TypePrice
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', length: 150)]
	private $fareTypeCode;

	#[ORM\Column(type: 'string', length: 200, nullable: true)]
	private $fareTypeDesc;

	#[ORM\Column(type: 'string', length: 50)]
	private $lang;

	#[ORM\Column(type: 'integer')]
	private $companyId;

	#[ORM\Column(type: 'datetime')]
	private $timestamp;

	/**
	 * @param $timestamp
	 */
	public function __construct($timestamp)
	{
		$this->timestamp = new \DateTime();
		$this->forfaitsConfigs = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getFareTypeCode(): ?string
	{
		return $this->fareTypeCode;
	}

	public function setFareTypeCode(string $fareTypeCode): self
	{
		$this->fareTypeCode = $fareTypeCode;

		return $this;
	}

	public function getFareTypeDesc(): ?string
	{
		return $this->fareTypeDesc;
	}

	public function setFareTypeDesc(?string $fareTypeDesc): self
	{
		$this->fareTypeDesc = $fareTypeDesc;

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

	public function getCompanyId(): ?int
	{
		return $this->companyId;
	}

	public function setCompanyId(int $companyId): self
	{
		$this->companyId = $companyId;

		return $this;
	}

	public function getTimestamp(): ?\DateTimeInterface
	{
		return $this->timestamp;
	}

	public function setTimestamp(\DateTimeInterface $timestamp): self
	{
		$this->timestamp = $timestamp;

		return $this;
	}
}
