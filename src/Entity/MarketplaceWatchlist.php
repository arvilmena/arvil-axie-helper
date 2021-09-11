<?php

namespace App\Entity;

use App\Repository\MarketplaceWatchlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketplaceWatchlistRepository::class)
 */
class MarketplaceWatchlist
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $payload;

    /**
     * Each watchlist item has many crawls. This is the inverse side.
     * @ORM\OneToMany(targetEntity="MarketplaceCrawl", mappedBy="marketplaceWatchlist", orphanRemoval=true, cascade={"remove"})
     */
    private $crawls;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderWeight;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $shouldCrawlMorePage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $notifyPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $notifyPriceEth;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $useRealtimePriceMonitoring = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $excludeWhenZeroEnergyCardGte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $excludeWhenSumOfEnergyLte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $excludeAvgAtkPerCardLte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $excludeFreaksQualityLte;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $excludeWhenSumOfEnergyGte;

    public function __construct() {
        $this->crawls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return Collection|MarketplaceCrawl[]
     */
    public function getCrawls(): Collection
    {
        return $this->crawls;
    }

    public function addCrawl(MarketplaceCrawl $crawl): self
    {
        if (!$this->crawls->contains($crawl)) {
            $this->crawls[] = $crawl;
            $crawl->setMarketplaceWatchlist($this);
        }

        return $this;
    }

    public function removeCrawl(MarketplaceCrawl $crawl): self
    {
        if ($this->crawls->removeElement($crawl)) {
            // set the owning side to null (unless already changed)
            if ($crawl->getMarketplaceWatchlist() === $this) {
                $crawl->setMarketplaceWatchlist(null);
            }
        }

        return $this;
    }

    public function getOrderWeight(): ?int
    {
        return $this->orderWeight;
    }

    public function setOrderWeight(?int $orderWeight): self
    {
        $this->orderWeight = $orderWeight;

        return $this;
    }

    public function getShouldCrawlMorePage(): ?bool
    {
        return $this->shouldCrawlMorePage;
    }

    public function setShouldCrawlMorePage(?bool $shouldCrawlMorePage): self
    {
        $this->shouldCrawlMorePage = $shouldCrawlMorePage;

        return $this;
    }

    public function getNotifyPrice(): ?float
    {
        return $this->notifyPrice;
    }

    public function setNotifyPrice(?float $notifyPrice): self
    {
        $this->notifyPrice = $notifyPrice;

        return $this;
    }

    public function getUseRealtimePriceMonitoring(): ?bool
    {
        return $this->useRealtimePriceMonitoring;
    }

    public function setUseRealtimePriceMonitoring(bool $useRealtimePriceMonitoring): self
    {
        $this->useRealtimePriceMonitoring = $useRealtimePriceMonitoring;

        return $this;
    }

    public function getExcludeWhenZeroEnergyCardGte(): ?int
    {
        return $this->excludeWhenZeroEnergyCardGte;
    }

    public function setExcludeWhenZeroEnergyCardGte(?int $excludeWhenZeroEnergyCardGte): self
    {
        $this->excludeWhenZeroEnergyCardGte = $excludeWhenZeroEnergyCardGte;

        return $this;
    }

    public function getExcludeWhenSumOfEnergyLte(): ?int
    {
        return $this->excludeWhenSumOfEnergyLte;
    }

    public function setExcludeWhenSumOfEnergyLte(?int $excludeWhenSumOfEnergyLte): self
    {
        $this->excludeWhenSumOfEnergyLte = $excludeWhenSumOfEnergyLte;

        return $this;
    }

    public function getExcludeAvgAtkPerCardLte(): ?float
    {
        return $this->excludeAvgAtkPerCardLte;
    }

    public function setExcludeAvgAtkPerCardLte(?float $excludeAvgAtkPerCardLte): self
    {
        $this->excludeAvgAtkPerCardLte = $excludeAvgAtkPerCardLte;

        return $this;
    }

    public function getExcludeFreaksQualityLte(): ?float
    {
        return $this->excludeFreaksQualityLte;
    }

    public function setExcludeFreaksQualityLte(?float $excludeFreaksQualityLte): self
    {
        $this->excludeFreaksQualityLte = $excludeFreaksQualityLte;

        return $this;
    }

    public function getNotifyPriceEth(): ?float
    {
        return $this->notifyPriceEth;
    }

    public function setNotifyPriceEth(?float $notifyPriceEth): self
    {
        $this->notifyPriceEth = $notifyPriceEth;

        return $this;
    }

    public function getExcludeWhenSumOfEnergyGte(): ?int
    {
        return $this->excludeWhenSumOfEnergyGte;
    }

    public function setExcludeWhenSumOfEnergyGte(?int $excludeWhenSumOfEnergyGte): self
    {
        $this->excludeWhenSumOfEnergyGte = $excludeWhenSumOfEnergyGte;

        return $this;
    }
}
