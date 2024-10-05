<?php

namespace App\Filter\Search;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;
use App\Service\DateUtilityService;

class Asap implements AvailableTermsSearchInterface
{
    public function __construct(
        private DateUtilityService $dateUtilityService
    ) {
    }

    public function search(AvailableTermsEnquiryInterface $enquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface
    {
        $availableFrom = $enquiry->getAvailableFrom();
        $asapAvailableDate = '';
        if (empty($bookedTerms)) {
            $asapAvailableDate = $availableFrom;
        } else {
            foreach ($bookedTerms as $termId => $term) {
                $startDate = $term->getFromDate();
                $endDate = $term->getToDate();

                if (($startDate > $availableFrom) && ($termId === 0)) {
                    $asapAvailableDate = $availableFrom;
                    break;
                }

                $nextDayAfterEndOfTerm = $this->dateUtilityService->getNextDay($endDate);
                $nextTerm = next($bookedTerms);
                if (true === (bool) $nextTerm) {
                    if ($nextTerm->getFromDate() > $endDate) {
                        $asapAvailableDate = $nextDayAfterEndOfTerm;
                        break;
                    }
                } else {
                    $asapAvailableDate = $nextDayAfterEndOfTerm;
                    break;
                }
            }
        }

        if ($asapAvailableDate) {
            $enquiry->addAvailableTerm($asapAvailableDate);
        }
        return $enquiry;
    }
}
