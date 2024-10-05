<?php

declare(strict_types=1);

namespace App\Filter;

use App\DTO\CompetenciesEnquiryInterface;
use App\Filter\CompetenciesFilter\CompetenciesFilterAggregator;

final class ItGuysWithCompetenciesFilter implements ItGuysWithCompetenciesFilterInterface
{
    public function __construct(
        private CompetenciesFilterAggregator $aggregator
    ) {
    }

    public function apply(CompetenciesEnquiryInterface $competenciesEnquiry, array $itGuysWithCompetencies): CompetenciesEnquiryInterface
    {
        $searchCompetencies = array_map(
            'strtolower',
            $competenciesEnquiry->getCompetencies()
        );
        $requestedCompetencyCount = count($searchCompetencies);
        if (0 === $requestedCompetencyCount) {
            $competenciesEnquiry->setItGuys($itGuysWithCompetencies);
            return $competenciesEnquiry;
        }
        $this->aggregator->filter($competenciesEnquiry, $itGuysWithCompetencies);

        return $competenciesEnquiry;
    }
}
