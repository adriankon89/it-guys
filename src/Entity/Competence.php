<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
final class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ItGuy::class, mappedBy: 'competencies')]
    private Collection $itGuys;

    public function __construct()
    {
        $this->itGuys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getItGuys(): Collection
    {
        return $this->itGuys;
    }

    public function addItGuy(ItGuy $itGuy): static
    {
        if (!$this->itGuys->contains($itGuy)) {
            $this->itGuys->add($itGuy);
            $itGuy->addCompetency($this);
        }

        return $this;
    }

    public function removeItGuy(ItGuy $itGuy): static
    {
        if ($this->itGuys->removeElement($itGuy)) {
            $itGuy->removeCompetency($this);
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->getName();
    }
}
