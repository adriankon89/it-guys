<?php

namespace App\Filter\Search\Factory;

use App\Exception\AvailableTermsClassNotFound;
use App\Filter\Search\AvailableTermsSearchInterface;
use App\Service\DateUtilityService;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class AvailableTermsFactory implements AvailableTermsFactoryInterface
{
    public function create(string $searchType): AvailableTermsSearchInterface
    {
        $searchEngineClassBasename = str_replace('_', '', ucwords($searchType, '_'));
        $searchEngine = self::SEARCH_MODIFIER_NAMESPACE . $searchEngineClassBasename;
        if (!class_exists($searchEngine)) {
            throw new AvailableTermsClassNotFound($searchEngine);
        }
        $dateUtilityService = new DateUtilityService();
        return new $searchEngine($dateUtilityService);
    }
}
