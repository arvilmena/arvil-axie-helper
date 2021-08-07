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
}
