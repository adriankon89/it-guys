<?php

declare(strict_types=1);

namespace App\Filter\Search\Factory;

use App\Filter\Search\AvailableTermsSearchInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AvailableTermsFactory implements AvailableTermsFactoryInterface
{
    private ContainerInterface $container;
    private array $searchTypeMap;

    public function __construct(ContainerInterface $container, array $searchTypeMap)
    {
        $this->container = $container;
        $this->searchTypeMap = $searchTypeMap;
    }

    public function create(string $searchType): AvailableTermsSearchInterface
    {
        if (!isset($this->searchTypeMap[$searchType])) {
            throw new NotFoundHttpException("Search type '{$searchType}' is not defined.");
        }

        $serviceId = $this->searchTypeMap[$searchType];

        if (!$this->container->has($serviceId)) {
            throw new NotFoundHttpException("The search engine '{$serviceId}' is not registered as a service.");
        }
        return $this->container->get($serviceId);
    }
}
