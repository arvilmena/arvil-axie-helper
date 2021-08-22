<?php

namespace App\Entity;

use App\Repository\ScholarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScholarRepository::class)
 */
class Scholar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $roninAddress;

    /**
     * @ORM\OneToMany(targetEntity=ScholarHistory::class, mappedBy="scholar", orphanRemoval=true)
     */
    private $scholarHistories;

    public function __construct()
    {
        $this->scholarHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoninAddress(): ?string
    {
        return $this->roninAddress;
    }

    public function setRoninAddress(string $roninAddress): self
    {
        $this->roninAddress = $roninAddress;

        return $this;
    }

    /**
     * @return Collection|ScholarHistory[]
     */
    public function getScholarHistories(): Collection
    {
        return $this->scholarHistories;
    }

    public function addScholarHistory(ScholarHistory $scholarHistory): self
    {
        if (!$this->scholarHistories->contains($scholarHistory)) {
            $this->scholarHistories[] = $scholarHistory;
            $scholarHistory->setScholar($this);
        }

        return $this;
    }

    public function removeScholarHistory(ScholarHistory $scholarHistory): self
    {
        if ($this->scholarHistories->removeElement($scholarHistory)) {
            // set the owning side to null (unless already changed)
            if ($scholarHistory->getScholar() === $this) {
                $scholarHistory->setScholar(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
