<?php

declare(strict_types=1);

namespace App\Filter\CompetenciesFilter;

use App\DTO\CompetenciesEnquiryInterface;

final class CompetenciesFilterAggregator
{
    /** @var array<StrictCompetenciesStrategy> */
    private array $competenciesHandlers;
    public function __construct(iterable $competenciesHandlers)
    {
        $this->competenciesHandlers = $competenciesHandlers;
    }

    public function filter(CompetenciesEnquiryInterface $competenciesEnquiry, array $itGuys)
    {
        foreach ($this->competenciesHandlers as $handler) {
            if ($handler->supports($competenciesEnquiry)) {
                $handler->filter($competenciesEnquiry, $itGuys);

                return;
            }

        }
    }
}
