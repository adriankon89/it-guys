<?php

declare(strict_types=1);

namespace App\Cache;

use App\Repository\ItGuyRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CompetenceCache
{
    public function __construct(
        private CacheInterface $cache,
        private ItGuyRepository $repository,
    ) {
    }
    public function getItGuysWithCompetencies(): ?array
    {
        return $this->cache->get("get-it-guys-with-competencies", function (ItemInterface $item) {
            return  $this->repository->getItGuysWithCompetencies();
        });
    }
}
