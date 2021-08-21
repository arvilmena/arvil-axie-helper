<?php

namespace App\Entity;

use App\Repository\AxieNotificationPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieNotificationPriceRepository::class)
 */
class AxieNotificationPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Axie::class, inversedBy="axieNotificationPrice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $alertOnlyWhenPriceBelow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAxie(): ?Axie
    {
        return $this->axie;
    }

    public function setAxie(Axie $axie): self
    {
        $this->axie = $axie;

        return $this;
    }

    public function getAlertOnlyWhenPriceBelow(): ?float
    {
        return $this->alertOnlyWhenPriceBelow;
    }

    public function setAlertOnlyWhenPriceBelow(?float $alertOnlyWhenPriceBelow): self
    {
        $this->alertOnlyWhenPriceBelow = $alertOnlyWhenPriceBelow;

        return $this;
    }
}
