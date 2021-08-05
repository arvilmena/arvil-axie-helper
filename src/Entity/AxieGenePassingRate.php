<?php

namespace App\Entity;

use App\Repository\AxieGenePassingRateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieGenePassingRateRepository::class)
 */
class AxieGenePassingRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class, inversedBy="genePassingRates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $passingRate;

    /**
     * @ORM\ManyToOne(targetEntity=AxiePart::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $part;

    public function __construct()
    {
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

    public function getGene(): ?AxiePart
    {
        return $this->gene;
    }

    public function setGene(AxiePart $gene): self
    {
        $this->gene = $gene;

        return $this;
    }

    public function getPassingRate(): ?float
    {
        return $this->passingRate;
    }

    public function setPassingRate(?float $passingRate): self
    {
        $this->passingRate = $passingRate;

        return $this;
    }

    public function getPart(): ?AxiePart
    {
        return $this->part;
    }

    public function setPart(?AxiePart $part): self
    {
        $this->part = $part;

        return $this;
    }
}
