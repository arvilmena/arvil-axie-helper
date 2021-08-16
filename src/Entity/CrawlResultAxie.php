<?php

namespace App\Entity;

use App\Repository\CrawlResultAxieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CrawlResultAxieRepository::class)
 */
class CrawlResultAxie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MarketplaceCrawl::class, inversedBy="crawlResultAxies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $crawl;

    /**
     * @ORM\Column(type="ulid", nullable=true)
     */
    private $crawlUlid;

    /**
     * @ORM\ManyToOne(targetEntity=AxieHistory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $axieHistory;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct(\DateTimeInterface $dateTime)
    {
        $this->date = $dateTime;
    }

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

    public function getCrawlUlid()
    {
        return $this->crawlUlid;
    }

    public function setCrawlUlid($crawlUlid): self
    {
        $this->crawlUlid = $crawlUlid;

        return $this;
    }

    public function getAxieHistory(): ?AxieHistory
    {
        return $this->axieHistory;
    }

    public function setAxieHistory(?AxieHistory $axieHistory): self
    {
        $this->axieHistory = $axieHistory;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
