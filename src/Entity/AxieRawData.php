<?php

namespace App\Entity;

use App\Repository\AxieRawDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieRawDataRepository::class)
 */
class AxieRawData
{

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rawData;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=Axie::class, inversedBy="axieRawData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rawDataBrief;

    public function __construct(Axie $axie) {
        $this->axie = $axie;
    }

    public function getId()
    {
        return $this->axie;
    }

    public function getRawData(): ?string
    {
        return $this->rawData;
    }

    public function setRawData(string $rawData): self
    {
        $this->rawData = $rawData;

        return $this;
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

    public function getRawDataBrief(): ?string
    {
        return $this->rawDataBrief;
    }

    public function setRawDataBrief(?string $rawDataBrief): self
    {
        $this->rawDataBrief = $rawDataBrief;

        return $this;
    }
}
