<?php

namespace App\Entity;

use App\Repository\AxieGenesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieGenesRepository::class)
 */
class AxieGenes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class, inversedBy="genes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\ManyToOne(targetEntity=AxiePart::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $part;

    /**
     * @ORM\ManyToOne(targetEntity=AxieCardAbility::class)
     */
    private $cardAbility;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $geneType;

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

    public function getPart(): ?AxiePart
    {
        return $this->part;
    }

    public function setPart(?AxiePart $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getCardAbility(): ?AxieCardAbility
    {
        return $this->cardAbility;
    }

    public function setCardAbility(?AxieCardAbility $cardAbility): self
    {
        $this->cardAbility = $cardAbility;

        return $this;
    }

    public function getGeneType(): ?string
    {
        return $this->geneType;
    }

    public function setGeneType(string $geneType): self
    {
        $this->geneType = $geneType;

        return $this;
    }
}
