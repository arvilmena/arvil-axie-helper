<?php

namespace App\Entity;

use App\Repository\ScholarHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScholarHistoryRepository::class)
 */
class ScholarHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Scholar::class, inversedBy="scholarHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scholar;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gameSlp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalSlp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastClaim;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $elo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $roninSlp;

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

    public function getScholar(): ?Scholar
    {
        return $this->scholar;
    }

    public function setScholar(?Scholar $scholar): self
    {
        $this->scholar = $scholar;

        return $this;
    }

    public function getGameSlp(): ?int
    {
        return $this->gameSlp;
    }

    public function setGameSlp(?int $gameSlp): self
    {
        $this->gameSlp = $gameSlp;

        return $this;
    }

    public function getTotalSlp(): ?int
    {
        return $this->totalSlp;
    }

    public function setTotalSlp(?int $totalSlp): self
    {
        $this->totalSlp = $totalSlp;

        return $this;
    }

    public function getLastClaim(): ?\DateTimeInterface
    {
        return $this->lastClaim;
    }

    public function setLastClaim(?\DateTimeInterface $lastClaim): self
    {
        $this->lastClaim = $lastClaim;

        return $this;
    }

    public function getElo(): ?int
    {
        return $this->elo;
    }

    public function setElo(?int $elo): self
    {
        $this->elo = $elo;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getRoninSlp(): ?int
    {
        return $this->roninSlp;
    }

    public function setRoninSlp(?int $roninSlp): self
    {
        $this->roninSlp = $roninSlp;

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
