<?php

declare(strict_types=1);

namespace App\Filter\CompetenciesFilter;

use App\DTO\CompetenciesEnquiryInterface;

interface CompetenciesFilterStrategyInterface
{
    public function filter(CompetenciesEnquiryInterface $competenciesEnquiry, array $itGuys): void;

    public function supports(CompetenciesEnquiryInterface $competenciesEnquiry): bool;
}
