<?php

namespace App\Filter\Search;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;
use App\Service\DateUtilityService;
use DateTime;

class Asap implements AvailableTermsSearchInterface
{
    public function __construct(
        private DateUtilityService $dateUtilityService
    ) {
    }

    public function search(
        AvailableTermsEnquiryInterface $enquiry,
        TimeSheet ...$bookedTerms
    ): AvailableTermsEnquiryInterface {
        $availableFrom = $enquiry->getAvailableFrom();
        $asapAvailableDate = null;
        if (true === empty($bookedTerms)) {
            $asapAvailableDate = $availableFrom;
        } else {
            foreach ($bookedTerms as $termId => $term) {
                $startDate = $term->getFromDate();
                $endDate = $term->getToDate();
                if (($startDate->format('Y-m-d') > $availableFrom->format('Y-m-d')) && ($termId === 0)) {
                    $asapAvailableDate = $availableFrom;
                    break;
                }

                $nextDayAfterEndOfTerm = $this->dateUtilityService->getNextDay($endDate);
                $nextTerm = next($bookedTerms);
                if (true === (bool) $nextTerm) {
                    if ($nextTerm->getFromDate()->format('Y-m-d') > $endDate->format('Y-m-d')) {
                        $asapAvailableDate = $nextDayAfterEndOfTerm;
                        break;
                    }
                } else {
                    $asapAvailableDate = $nextDayAfterEndOfTerm;
                    break;
                }
            }
        }
        if (null !== $asapAvailableDate) {
            $enquiry->addAvailableTerm($asapAvailableDate);
        }

        return $enquiry;
    }
}
