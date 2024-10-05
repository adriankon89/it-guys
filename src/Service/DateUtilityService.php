<?php

declare(strict_types=1);

namespace App\Service;

use DateTimeInterface;

final class DateUtilityService
{
    public function getNextDay(string $date): DateTimeInterface
    {
        return (new \DateTime($date))->modify('+1 day');
    }

}
