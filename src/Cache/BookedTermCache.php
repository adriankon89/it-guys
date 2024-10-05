<?php

declare(strict_types=1);

namespace App\Cache;

use App\Entity\ItGuy;
use App\Repository\TimeSheetRepository;
use DateTimeInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class BookedTermCache
{
    public function __construct(
        private CacheInterface $cache,
        private TimeSheetRepository $repository,
    ) {

    }
    public function findItGuyBookedTerms(ItGuy $itGuy, DateTimeInterface $availableFrom): ?array
    {

        return  $this->repository->findItGuyBookedTerms(
            $itGuy,
            $availableFrom
        );

        return $this->cache->get("itguy-booked-terms-{$itGuy->getId()}", function (ItemInterface $item) use ($itGuy, $availableFrom) {
            return  $this->repository->findItGuyBookedTerms(
                $itGuy,
                $availableFrom
            );
        });
    }
}
