<?php

namespace App\Entity;

use App\Repository\RecentlySoldAxieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecentlySoldAxieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class RecentlySoldAxie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Axie::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $axie;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     */
    private $priceEth;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $priceUsd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $breedCount;

    /**
     * @ORM\ManyToOne(targetEntity=AxieCardAbility::class)
     */
    private $backCard;

    /**
     * @ORM\ManyToOne(targetEntity=AxieCardAbility::class)
     */
    private $mouthCard;

    /**
     * @ORM\ManyToOne(targetEntity=AxieCardAbility::class)
     */
    private $hornCard;

    /**
     * @ORM\ManyToOne(targetEntity=AxieCardAbility::class)
     */
    private $tailCard;

    /**
     * @ORM\PrePersist()
     * @throws \Exception
     */
    public function prePersist() : void {
        if ($this->getDate() === null) {
            $this->setDate(new \DateTime('now', new \DateTimeZone('UTC')));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setPriceEth(float $priceEth): self
    {
        $this->priceEth = $priceEth;

        return $this;
    }

    public function getPriceUsd(): ?float
    {
        return $this->priceUsd;
    }

    public function setPriceUsd(float $priceUsd): self
    {
        $this->priceUsd = $priceUsd;

        return $this;
    }

    public function getBreedCount(): ?int
    {
        return $this->breedCount;
    }

    public function setBreedCount(?int $breedCount): self
    {
        $this->breedCount = $breedCount;

        return $this;
    }

    public function getBackCard(): ?AxieCardAbility
    {
        return $this->backCard;
    }

    public function setBackCard(?AxieCardAbility $backCard): self
    {
        $this->backCard = $backCard;

        return $this;
    }

    public function getMouthCard(): ?AxieCardAbility
    {
        return $this->mouthCard;
    }

    public function setMouthCard(?AxieCardAbility $mouthCard): self
    {
        $this->mouthCard = $mouthCard;

        return $this;
    }

    public function getHornCard(): ?AxieCardAbility
    {
        return $this->hornCard;
    }

    public function setHornCard(?AxieCardAbility $hornCard): self
    {
        $this->hornCard = $hornCard;

        return $this;
    }

    public function getTailCard(): ?AxieCardAbility
    {
        return $this->tailCard;
    }

    public function setTailCard(?AxieCardAbility $tailCard): self
    {
        $this->tailCard = $tailCard;

        return $this;
    }
}
