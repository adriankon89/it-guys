<?php

declare(strict_types=1);

namespace App\Filter;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;
use App\Filter\Search\Factory\AvailableTermsFactoryInterface;

final class AvailableTermsFilter implements AvailableTermsFilterInterface
{
    public function __construct(
        private AvailableTermsFactoryInterface $availableTermsFactory
    ) {
    }

    public function apply(AvailableTermsEnquiryInterface $enquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface
    {
        $availableTerms = $this->availableTermsFactory
            ->create($enquiry->getAvailableType());
        $availableTerms->search($enquiry, ...$bookedTerms);
        return $enquiry;
    }
}
