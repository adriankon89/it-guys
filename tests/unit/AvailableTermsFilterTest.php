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
    public function testLastAvailableTermsFilter(): void
    {
        //given
        $date = new DateTime('now');
        $availableTermsEnquiry = new AvailableTermsEnquiry();
        $availableTermsEnquiry->setAvailableFrom($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableTo($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableType('last-available');
        $bookedTerms = $this->bookedTermsDataForTodayProvider();

        //when
        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        $filteredEnquiry = $availableTermsFilter->apply($availableTermsEnquiry, ...$bookedTerms);

        //then
        $nextAvailableDay = $filteredEnquiry->getAvailableDates()[0]->format('Y-m-d');
        $tomorrowDate = (clone $date)->modify('+1 day')->format('Y-m-d');
        $this->assertSame($nextAvailableDay, $tomorrowDate);
    }

    public function testAsapFilterReturnsTodayWhenNoBookedTermsExist(): void
    {
        //given
        $date = new DateTime('now');
        $availableTermsEnquiry = new AvailableTermsEnquiry();
        $availableTermsEnquiry->setAvailableFrom($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableTo($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableType('asap');

        //when
        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        $filteredEnquiry = $availableTermsFilter->apply($availableTermsEnquiry, ...[]);

        //then
        $nextAvailableDay = $filteredEnquiry->getAvailableDates()[0]->format('Y-m-d');
        $today = (clone $date)->format('Y-m-d');
        $this->assertSame($nextAvailableDay, $today);
    }

    public function testAsapFilterForMoreTimeSheets(): void
    {
        //given
        $date = new DateTime('now');
        $availableTermsEnquiry = new AvailableTermsEnquiry();
        $availableTermsEnquiry->setAvailableFrom($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableTo($date->format('Y-m-d'));
        $availableTermsEnquiry->setAvailableType('asap');
        $bookedTerms = $this->bookedTermsWithMoreTimeSheetsDataProvider();

        //when
        $availableTermsFilter = $this->container->get(AvailableTermsFilter::class);
        $filteredEnquiry = $availableTermsFilter->apply($availableTermsEnquiry, ...$bookedTerms);

        //then
        $nextAvailableDay = $filteredEnquiry->getAvailableDates()[0]->format('Y-m-d');
        $tomorrow = (clone $date)->modify('+ 1 day')->format('Y-m-d');
        $this->assertSame($nextAvailableDay, $tomorrow);

    }

    /**
     * Provides booked terms for today.
     *
     * @return TimeSheet[]
     */
    public function bookedTermsDataForTodayProvider()
    {
        $timeSheet = new TimeSheet();
        $date = new DateTime('now');
        $timeSheet->setFromDate($date);
        $timeSheet->setToDate($date);

        return [$timeSheet];
    }

    /**
     * Provides booked terms for today.
     *
     * @return TimeSheet[]
     */
    public function bookedTermsWithMoreTimeSheetsDataProvider()
    {
        $date = new DateTime('now');
        $firstTimeSheet = new TimeSheet();
        $firstTimeSheet->setFromDate($date);
        $firstTimeSheet->setToDate($date);
        $futureDate = (clone $date)->modify('+5 days');
        $secondTimeSheet = new TimeSheet();
        $secondTimeSheet->setFromDate($futureDate);
        $secondTimeSheet->setToDate($futureDate);

        return [$firstTimeSheet, $secondTimeSheet];
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
