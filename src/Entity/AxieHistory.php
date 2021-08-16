<?php

namespace App\Entity;

use App\Repository\AxieHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieHistoryRepository::class)
 */
class AxieHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class, inversedBy="axieHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceEth;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceUsd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $breedCount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct(\DateTimeInterface $dateTime) {
        $this->date = $dateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAxie(): ?Axie
    {
        return $this->axie;
    }

    public function setAxie(?Axie $axie): self
    {
        $this->axie = $axie;

        return $this;
    }

    public function getPriceEth(): ?float
    {
        return $this->priceEth;
    }

    public function setPriceEth(?float $priceEth): self
    {
        $this->priceEth = $priceEth;

        return $this;
    }

    public function getPriceUsd(): ?float
    {
        return $this->priceUsd;
    }

    public function setPriceUsd(?float $priceUsd): self
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }

    public function getBreedCount(): ?int
    {
        return $this->breedCount;
    }

    public function setBreedCount(?int $breedCount): self
    {
        $this->breedCount = $breedCount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
