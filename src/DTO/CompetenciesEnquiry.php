<?php

namespace App\DTO;

use App\Entity\ItGuy;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CompetenciesEnquiry implements BaseDtoInterface, CompetenciesEnquiryInterface
{
    #[Groups(['competencies'])]
    private array $itGuys = [];
    #[Groups(['competencies'])]
    private array $competencies = [];
    #[Assert\Type('bool')]
    private bool $strictSearch = false;

    public function getCompetencies(): array
    {
        return $this->competencies;
    }

    public function setCompetencies(?array $competencies): self
    {
        $this->competencies = $competencies;

        return $this;
    }

    public function getItGuys(): array
    {
        return $this->itGuys;
    }

    public function setItGuys(?array $itGuys): self
    {
        $this->itGuys = $itGuys;

        return $this;
    }

    public function addItGuy(ItGuy $itGuy): self
    {
        array_push($this->itGuys, $itGuy);

        return $this;
    }

    public function getStrictSearch(): bool
    {
        return $this->strictSearch;
    }

    public function setStrictSearch(bool $strictSearch): self
    {
        $this->strictSearch = $strictSearch;

        return $this;
    }
}
