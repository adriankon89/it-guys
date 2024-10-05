<?php

namespace App\Filter;

use App\DTO\CompetenciesEnquiryInterface;

interface ItGuysWithCompetenciesFilterInterface
{
    public function apply(CompetenciesEnquiryInterface $competenciesEnquiry, array $itGuys): CompetenciesEnquiryInterface;
}
