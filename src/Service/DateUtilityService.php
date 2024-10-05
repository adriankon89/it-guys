<?php

declare(strict_types=1);

namespace App\Service;

use DateTimeInterface;

final class DateUtilityService
{
    public function getNextDay(DateTimeInterface $date): DateTimeInterface
    {
        return $date->modify('+1 day');
    }

}
