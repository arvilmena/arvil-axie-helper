<?php

namespace App\Entity;

use App\Repository\MarketplaceCrawlRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
/**
 * @ORM\Entity(repositoryClass=MarketplaceCrawlRepository::class)
 */
class MarketplaceCrawl
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $crawlDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $baseUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $page;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $request;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $response;

    /**
     * @ORM\Column(type="ulid", nullable=true)
     */
    private $crawlSessionUlid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $statusCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $browserRequestId;

    /**
     * Many Crawls have one watchlist. This is the owning side.
     * @ManyToOne(targetEntity="MarketplaceWatchlist", inversedBy="crawls")
     * @JoinColumn(name="marketplace_watchlist_id", referencedColumnName="id", nullable=true)
     */
    private $marketplaceWatchlist;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lowestPriceEth;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $highestPriceEth;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averagePriceEth;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lowestPriceUsd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $highestPriceUsd;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averagePriceUsd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfValidAxies;

    public function __construct(string $request, \DateTimeInterface $crawlDate) {
        $this->request = $request;
        $this->crawlDate = $crawlDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCrawlDate(): ?\DateTimeInterface
    {
        return $this->crawlDate;
    }

    public function setCrawlDate(\DateTimeInterface $crawlDate): self
    {
        $this->crawlDate = $crawlDate;

        return $this;
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

    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(?string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequest() : string
    {
        return $this->request;
    }

    /**
     * @param string $request
     */
    public function setRequest(string $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getBrowserRequestId(): ?string
    {
        return $this->browserRequestId;
    }

    public function setBrowserRequestId(?string $browserRequestId): self
    {
        $this->browserRequestId = $browserRequestId;

        return $this;
    }

    public function getMarketplaceWatchlist(): ?MarketplaceWatchlist
    {
        return $this->marketplaceWatchlist;
    }

    public function setMarketplaceWatchlist(?MarketplaceWatchlist $marketplaceWatchlist): self
    {
        $this->marketplaceWatchlist = $marketplaceWatchlist;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getLowestPriceEth(): ?float
    {
        return $this->lowestPriceEth;
    }

    public function setLowestPriceEth(?float $lowestPriceEth): self
    {
        $this->lowestPriceEth = $lowestPriceEth;

        return $this;
    }

    public function getHighestPriceEth(): ?float
    {
        return $this->highestPriceEth;
    }

    public function setHighestPriceEth(?float $highestPriceEth): self
    {
        $this->highestPriceEth = $highestPriceEth;

        return $this;
    }

    public function getAveragePriceEth(): ?float
    {
        return $this->averagePriceEth;
    }

    public function setAveragePriceEth(?float $averagePriceEth): self
    {
        $this->averagePriceEth = $averagePriceEth;

        return $this;
    }

    public function getLowestPriceUsd(): ?float
    {
        return $this->lowestPriceUsd;
    }

    public function setLowestPriceUsd(?float $lowestPriceUsd): self
    {
        $this->lowestPriceUsd = $lowestPriceUsd;

        return $this;
    }

    public function getHighestPriceUsd(): ?float
    {
        return $this->highestPriceUsd;
    }

    public function setHighestPriceUsd(?float $highestPriceUsd): self
    {
        $this->highestPriceUsd = $highestPriceUsd;

        return $this;
    }

    public function getAveragePriceUsd(): ?float
    {
        return $this->averagePriceUsd;
    }

    public function setAveragePriceUsd(?float $averagePriceUsd): self
    {
        $this->averagePriceUsd = $averagePriceUsd;

        return $this;
    }

    public function getNumberOfValidAxies(): ?int
    {
        return $this->numberOfValidAxies;
    }

    public function setNumberOfValidAxies(?int $numberOfValidAxies): self
    {
        $this->numberOfValidAxies = $numberOfValidAxies;

        return $this;
    }

    public function getCrawlSessionUlid()
    {
        return $this->crawlSessionUlid;
    }

    public function setCrawlSessionUlid($crawlSessionUlid): self
    {
        $this->crawlSessionUlid = $crawlSessionUlid;

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(?int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
