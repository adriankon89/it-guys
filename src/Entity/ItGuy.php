<?php

namespace App\Entity;

use App\Repository\ItGuyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItGuyRepository::class)]
class ItGuy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['competencies'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['competencies'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'itGuys')]
    private Collection $competencies;

    public function __construct()
    {
        $this->competencies = new ArrayCollection();
    }

    /*
    #[ORM\OneToMany(targetEntity: TimeSheet::class, mappedBy: 'itguy')]
    private Collection $timeSheets;

    public function __construct()
    {
        $this->timeSheets = new ArrayCollection();
    }
    */

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
    public function getCompetencies(): Collection
    {
        return $this->competencies;
    }

    public function addCompetency(Competence $competency): static
    {
        if (!$this->competencies->contains($competency)) {
            $this->competencies->add($competency);
        }

        return $this;
    }

    public function removeCompetency(Competence $competency): static
    {
        $this->competencies->removeElement($competency);

        return $this;
    }

}
