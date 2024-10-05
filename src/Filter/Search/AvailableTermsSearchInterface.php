<?php

namespace App\Filter\Search;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;

interface AvailableTermsSearchInterface
{
    public function search(AvailableTermsEnquiryInterface $enquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface;
}
