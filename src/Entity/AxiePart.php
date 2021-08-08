<?php

namespace App\Entity;

use App\Repository\AxiePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxiePartRepository::class)
 */
class AxiePart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\OneToOne(targetEntity=AxieCardAbility::class, inversedBy="axiePart")
     */
    private $cardAbility;

    /**
     * @ORM\ManyToMany(targetEntity=Axie::class, mappedBy="parts")
     */
    private $axies;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->axies = new ArrayCollection();
    }

    public function getId(): ?string
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

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

    /**
     * @return Collection|Axie[]
     */
    public function getAxies(): Collection
    {
        return $this->axies;
    }

    public function addAxy(Axie $axy): self
    {
        if (!$this->axies->contains($axy)) {
            $this->axies[] = $axy;
            $axy->addPart($this);
        }

        return $this;
    }

    public function removeAxy(Axie $axy): self
    {
        if ($this->axies->removeElement($axy)) {
            $axy->removePart($this);
        }

        return $this;
    }
}
