<?php

namespace App\Tests\unit;

use App\DTO\AvailableTermsEnquiry;
use App\Filter\AvailableTermsFilter;
use App\Tests\ServiceTestCase;

class AvailableTermsFilterTest extends ServiceTestCase
{
    //vendor/bin/phpunit tests/unit/AvailableTermsFilterTest

    /** @test */
    public function fancy_test_name_todo_on_weekend(): void
    {
        //given

        $enquiry = new AvailableTermsEnquiry();

        $bookedTerms = $this->bookedTermsDataProvider();

        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        dd($availableTermsFilter);

        //when
        //  $filteredEnquiry = $availableTermsFilter->apply($enquiry, ...$bookedTerms);


        //then
    }

    public function bookedTermsDataProvider()
    {
        return [
            ['2022-02-02' => '2022-02-02'],
            ['2022-02-02' => '2022-02-02'],

        ];
    }
}
