<?php

namespace App\Entity;

use App\Repository\RecentlySoldAxieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecentlySoldAxieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class RecentlySoldAxie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="float")
     */
    private $priceEth;

    /**
     * @ORM\Column(type="float")
     */
    private $priceUsd;

    /**
     * @ORM\PrePersist()
     * @throws \Exception
     */
    public function prePersist() : void {
        if ($this->getDate() === null) {
            $this->setDate(new \DateTime('now', new \DateTimeZone('UTC')));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setPriceEth(float $priceEth): self
    {
        $this->priceEth = $priceEth;

        return $this;
    }

    public function getPriceUsd(): ?float
    {
        return $this->priceUsd;
    }

    public function setPriceUsd(float $priceUsd): self
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }
}