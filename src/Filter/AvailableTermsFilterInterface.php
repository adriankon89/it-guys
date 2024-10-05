<?php

namespace App\Filter;

use App\DTO\AvailableTermsEnquiryInterface;
use App\Entity\TimeSheet;

interface AvailableTermsFilterInterface
{
    public function apply(AvailableTermsEnquiryInterface $availableTermsEnquiry, TimeSheet ...$bookedTerms): AvailableTermsEnquiryInterface;
}
