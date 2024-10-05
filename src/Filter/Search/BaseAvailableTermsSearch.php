<?php

namespace App\Filter\Search;

use DateTimeInterface;

abstract class BaseAvailableTermsSearch implements AvailableTermsSearchInterface
{
    protected function getNextDay(string $date): DateTimeInterface
    {
        return (new \DateTime($date))->modify('+1 day');
    }
}
