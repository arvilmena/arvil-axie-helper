<?php

namespace App\Entity;

use App\Repository\AxieCardAbilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AxieCardAbilityRepository::class)
 */
class AxieCardAbility
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attack;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $energy;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $backgroundUrl;

    /**
     * @ORM\OneToOne(targetEntity=AxiePart::class, mappedBy="cardAbility")
     */
    private $axiePart;

    public function __construct(string $id) {
        $this->id = $id;
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

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefence(): ?int
    {
        return $this->defence;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;

        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(int $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBackgroundUrl(): ?string
    {
        return $this->backgroundUrl;
    }

    public function setBackgroundUrl(?string $backgroundUrl): self
    {
        $this->backgroundUrl = $backgroundUrl;

        return $this;
    }

    public function getAxiePart(): ?AxiePart
    {
        return $this->axiePart;
    }

    public function setAxiePart(?AxiePart $axiePart): self
    {
        // unset the owning side of the relation if necessary
        if ($axiePart === null && $this->axiePart !== null) {
            $this->axiePart->setCardAbility(null);
        }

        // set the owning side of the relation if necessary
        if ($axiePart !== null && $axiePart->getCardAbility() !== $this) {
            $axiePart->setCardAbility($this);
        }

        $this->axiePart = $axiePart;

        return $this;
    }
}
