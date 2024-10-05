<?php

namespace App\Filter\Search\Factory;

use App\Filter\Search\AvailableTermsSearchInterface;

interface AvailableTermsFactoryInterface
{
    public function create(string $modifierType): AvailableTermsSearchInterface;
}
