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
     * Each watchlist item has many crawls;
     * @ORM\OneToMany(targetEntity="MarketplaceCrawl", mappedBy="marketplaceWatchlist")
     */
    private $crawls;

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
}