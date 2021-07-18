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
     * @ORM\Column(type="text", nullable=true)
     */
    private $rawData;

    /**
     * @ORM\OneToMany(targetEntity=CrawlAxieResult::class, mappedBy="axie")
     */
    private $crawlAxieResults;

    public function __construct(int $id) {
        $this->id = $id;
        $this->url = 'https://marketplace.axieinfinity.com/axie/' . $id;
        $this->crawlAxieResults = new ArrayCollection();
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

    public function getRawData(): ?string
    {
        return $this->rawData;
    }

    public function setRawData(?string $rawData): self
    {
        $this->rawData = $rawData;

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
}
