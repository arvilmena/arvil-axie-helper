<?php

namespace App\Entity;

use App\Repository\MarketplaceOverviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketplaceOverviewRepository::class)
 */
class MarketplaceOverview
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $span;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $axieSold;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $volumeEth;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $volumeUsd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalSold;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpan(): ?string
    {
        return $this->span;
    }

    public function setSpan(string $span): self
    {
        $this->span = $span;

        return $this;
    }

    public function getAxieSold(): ?int
    {
        return $this->axieSold;
    }

    public function setAxieSold(?int $axieSold): self
    {
        $this->axieSold = $axieSold;

        return $this;
    }

    public function getVolumeEth(): ?float
    {
        return $this->volumeEth;
    }

    public function setVolumeEth(?float $volumeEth): self
    {
        $this->volumeEth = $volumeEth;

        return $this;
    }

    public function getVolumeUsd(): ?string
    {
        return $this->volumeUsd;
    }

    public function setVolumeUsd(?string $volumeUsd): self
    {
        $this->volumeUsd = $volumeUsd;

        return $this;
    }

    public function getTotalSold(): ?int
    {
        return $this->totalSold;
    }

    public function setTotalSold(?int $totalSold): self
    {
        $this->totalSold = $totalSold;

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
