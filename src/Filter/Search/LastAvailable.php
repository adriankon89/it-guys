<?php

declare(strict_types=1);

namespace App\Filter\Search;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;
use App\Service\DateUtilityService;

final class LastAvailable implements AvailableTermsSearchInterface
{
    public function __construct(
        private DateUtilityService $dateUtilityService
    ) {
    }
    public function search(AvailableTermsEnquiryInterface $enquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface
    {
        $asapAvailableDate = empty($bookedTerms) ?
        $enquiry->getAvailableFrom() :
        $this->dateUtilityService->getNextDay(end($bookedTerms)->getToDate());

        $enquiry->addAvailableTerm($asapAvailableDate);

        return $enquiry;
    }
}
