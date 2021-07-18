<?php

namespace App\Entity;

use App\Repository\CrawlAxieResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CrawlAxieResultRepository::class)
 */
class CrawlAxieResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MarketplaceCrawl::class, inversedBy="crawlAxieResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crawl;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class, inversedBy="crawlAxieResults")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrawl(): ?MarketplaceCrawl
    {
        return $this->crawl;
    }

    public function setCrawl(?MarketplaceCrawl $crawl): self
    {
        $this->crawl = $crawl;

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
}
