<?php

namespace App\Filter\Search\Factory;

use App\Filter\Search\AvailableTermsSearchInterface;

interface AvailableTermsFactoryInterface
{
    public const SEARCH_MODIFIER_NAMESPACE = "App\Filter\Search\\";

    public function create(string $modifierType): AvailableTermsSearchInterface;
}
