<?php

declare(strict_types=1);

namespace App\Filter\CompetenciesFilter;

use App\DTO\CompetenciesEnquiryInterface;
use App\Entity\ItGuy;

class AtLeastOneCompetencyStrategy implements CompetenciesFilterStrategyInterface
{
    public function filter(CompetenciesEnquiryInterface $competenciesEnquiry, array $itGuys): void
    {
        $competenciesForSearch = $competenciesEnquiry->getCompetencies();
        $itGuys = array_filter($itGuys, function (ItGuy $itGuy) use ($competenciesForSearch) {
            $itGuyCompetencies = $itGuy->getCompetencies()->toArray();
            return (bool)  array_uintersect($competenciesForSearch, $itGuyCompetencies, 'strcasecmp');
        });
        $competenciesEnquiry->setItGuys($itGuys);

    }

    public function supports(CompetenciesEnquiryInterface $competenciesEnquiry): bool
    {
        return false === $competenciesEnquiry->getStrictSearch();
    }


}
