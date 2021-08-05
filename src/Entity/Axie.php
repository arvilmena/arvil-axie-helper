<?php

namespace App\Entity;

use App\Repository\AxieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieRepository::class)
 */
class Axie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\OneToMany(targetEntity=CrawlAxieResult::class, mappedBy="axie")
     */
    private $crawlAxieResults;

    /**
     * @ORM\ManyToMany(targetEntity=AxiePart::class, inversedBy="axies")
     * @ORM\JoinTable(name="axie_parts",
     *      joinColumns={@ORM\JoinColumn(name="axie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="axie_part_id", referencedColumnName="id")}
     * )
     */
    private $parts;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $dominantClassPurity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $r1ClassPurity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $r2ClassPurity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pureness;

    /**
     * @ORM\OneToMany(targetEntity=AxieGenes::class, mappedBy="axie", orphanRemoval=true)
     */
    private $genes;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     * @var $isProcessed bool
     */
    private $isProcessed = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $speed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $skill;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $morale;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $encodedGenes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quality;

    /**
     * @ORM\OneToOne(targetEntity=AxieRawData::class, mappedBy="axie", cascade={"persist", "remove"})
     */
    private $axieRawData;

    /**
     * @ORM\OneToMany(targetEntity=AxieGenePassingRate::class, mappedBy="axie", orphanRemoval=true)
     */
    private $genePassingRates;

    public function __construct(int $id) {
        $this->id = $id;
        $this->url = 'https://marketplace.axieinfinity.com/axie/' . $id;
        $this->crawlAxieResults = new ArrayCollection();
        $this->parts = new ArrayCollection();
        $this->genes = new ArrayCollection();
        $this->genePassingRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|CrawlAxieResult[]
     */
    public function getCrawlAxieResults(): Collection
    {
        return $this->crawlAxieResults;
    }

    public function addCrawlAxieResult(CrawlAxieResult $crawlAxieResult): self
    {
        if (!$this->crawlAxieResults->contains($crawlAxieResult)) {
            $this->crawlAxieResults[] = $crawlAxieResult;
            $crawlAxieResult->setAxie($this);
        }

        return $this;
    }

    public function removeCrawlAxieResult(CrawlAxieResult $crawlAxieResult): self
    {
        if ($this->crawlAxieResults->removeElement($crawlAxieResult)) {
            // set the owning side to null (unless already changed)
            if ($crawlAxieResult->getAxie() === $this) {
                $crawlAxieResult->setAxie(null);
            }
        }

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection|AxiePart[]
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(AxiePart $part): self
    {
        if (!$this->parts->contains($part)) {
            $this->parts[] = $part;
        }

        return $this;
    }

    public function removePart(AxiePart $part): self
    {
        $this->parts->removeElement($part);

        return $this;
    }

    public function getDominantClassPurity(): ?float
    {
        return $this->dominantClassPurity;
    }

    public function setDominantClassPurity(?float $dominantClassPurity): self
    {
        $this->dominantClassPurity = $dominantClassPurity;

        return $this;
    }

    public function getR1ClassPurity(): ?float
    {
        return $this->r1ClassPurity;
    }

    public function setR1ClassPurity(?float $r1ClassPurity): self
    {
        $this->r1ClassPurity = $r1ClassPurity;

        return $this;
    }

    public function getR2ClassPurity(): ?float
    {
        return $this->r2ClassPurity;
    }

    public function setR2ClassPurity(?float $r2ClassPurity): self
    {
        $this->r2ClassPurity = $r2ClassPurity;

        return $this;
    }

    public function getPureness(): ?int
    {
        return $this->pureness;
    }

    public function setPureness(?int $pureness): self
    {
        $this->pureness = $pureness;

        return $this;
    }

    /**
     * @return Collection|AxieGenes[]
     */
    public function getGenes(): Collection
    {
        return $this->genes;
    }

    public function addGene(AxieGenes $gene): self
    {
        if (!$this->genes->contains($gene)) {
            $this->genes[] = $gene;
            $gene->setAxie($this);
        }

        return $this;
    }

    public function removeGene(AxieGenes $gene): self
    {
        if ($this->genes->removeElement($gene)) {
            // set the owning side to null (unless already changed)
            if ($gene->getAxie() === $this) {
                $gene->setAxie(null);
            }
        }

        return $this;
    }

    public function getIsProcessed(): ?bool
    {
        return $this->isProcessed;
    }

    public function setIsProcessed(bool $isProcessed): self
    {
        $this->isProcessed = $isProcessed;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(?int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(?int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSkill(): ?int
    {
        return $this->skill;
    }

    public function setSkill(?int $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getMorale(): ?int
    {
        return $this->morale;
    }

    public function setMorale(?int $morale): self
    {
        $this->morale = $morale;

        return $this;
    }

    public function getEncodedGenes(): ?string
    {
        return $this->encodedGenes;
    }

    public function setEncodedGenes(?string $encodedGenes): self
    {
        $this->encodedGenes = $encodedGenes;

        return $this;
    }

    public function getQuality(): ?float
    {
        return $this->quality;
    }

    public function setQuality(?float $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getAxieRawData(): ?AxieRawData
    {
        return $this->axieRawData;
    }

    public function setAxieRawData(AxieRawData $axieRawData): self
    {
        // set the owning side of the relation if necessary
        if ($axieRawData->getAxie() !== $this) {
            $axieRawData->setAxie($this);
        }

        $this->axieRawData = $axieRawData;

        return $this;
    }

    /**
     * @return Collection|AxieGenePassingRate[]
     */
    public function getGenePassingRates(): Collection
    {
        return $this->genePassingRates;
    }

    public function addGenePassingRate(AxieGenePassingRate $genePassingRate): self
    {
        if (!$this->genePassingRates->contains($genePassingRate)) {
            $this->genePassingRates[] = $genePassingRate;
            $genePassingRate->setAxie($this);
        }

        return $this;
    }

    public function removeGenePassingRate(AxieGenePassingRate $genePassingRate): self
    {
        if ($this->genePassingRates->removeElement($genePassingRate)) {
            // set the owning side to null (unless already changed)
            if ($genePassingRate->getAxie() === $this) {
                $genePassingRate->setAxie(null);
            }
        }

        return $this;
    }
}
