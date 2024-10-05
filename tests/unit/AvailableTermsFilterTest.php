<?php

namespace App\Tests\unit;

use App\DTO\AvailableTermsEnquiry;
use App\Entity\TimeSheet;
use App\Filter\AvailableTermsFilter;
use App\Tests\ServiceTestCase;
use DateTime;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AvailableTermsFilterTest extends ServiceTestCase
{
    public function testAsapAvailableTermsFilter(): void
    {
        //given
        $date = new DateTime('now');
        $availableTermsEnquiry = new AvailableTermsEnquiry();
        $availableTermsEnquiry->setAvailableFrom($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableTo($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableType('last-available');
        $bookedTerms = $this->bookedTermsDataProvider();

        //when
        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        $filteredEnquiry = $availableTermsFilter->apply($availableTermsEnquiry, ...$bookedTerms);

        //then
        $nextAvailableDay = $filteredEnquiry->getAvailableDates()[0]->format('Y-m-d');
        $tomorrowDate = (clone $date)->modify('+1 day')->format('Y-m-d');
        $this->assertSame($nextAvailableDay, $tomorrowDate);
    }

    public function bookedTermsDataProvider()
    {
        $timeSheet = new TimeSheet();
        $date = new DateTime('now');
        $timeSheet->setFromDate($date);
        $timeSheet->setToDate($date);
        return [$timeSheet];
    }

    public function testNotFoundFilter()
    {
        // given
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage("Search type 'strange-name' is not defined");

        $availableTermsEnquiry = new AvailableTermsEnquiry();
        $availableTermsEnquiry->setAvailableType('strange-name');

        // when
        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        $availableTermsFilter->apply($availableTermsEnquiry, ...[]);
    }
}
