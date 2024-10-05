<?php

namespace App\DTO;

use App\Entity\ItGuy;

interface CompetenciesEnquiryInterface
{
    public function getCompetencies(): array;
    public function setCompetencies(?array $competencies): self;
    public function getItGuys(): array;
    public function setItGuys(?array $isGuys): self;
    public function addItGuy(ItGuy $itGuy): self;
    public function getStrictSearch(): bool;
    public function setStrictSearch(bool $strictSearch): self;
}
