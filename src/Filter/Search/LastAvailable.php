<?php

declare(strict_types=1);

namespace App\Filter\Search;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;

final class LastAvailable extends BaseAvailableTermsSearch
{
    public function search(AvailableTermsEnquiryInterface $enquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface
    {
        $availableFrom = $enquiry->getAvailableFrom();
        $asapAvailableDate = '';
        if (true === empty($bookedTerms)) {
            $asapAvailableDate = $availableFrom;
        } else {
            $lastTerm = end($bookedTerms);
            $endDateOfLastTerm = $lastTerm->getToDate()->format('Y-m-d');
            $asapAvailableDate = $this->getNextDay($endDateOfLastTerm);
        }

        if ($asapAvailableDate) {
            $enquiry->addAvailableTerm($asapAvailableDate);
        }

        return $enquiry;
    }
}
