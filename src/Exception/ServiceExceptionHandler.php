<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\ServiceException as ServiceServiceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ServiceExceptionHandler implements ExceptionHandler
{
    public function handle(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $exceptionData = $exception->getExceptionData();
        $response = new JsonResponse($exceptionData->toArray());
        $event->setResponse($response);
    }

    public function supports(\Throwable $throwable): bool
    {
        return true === $throwable instanceof ServiceServiceException;
    }

    public function priority(): int
    {
        return 100;
    }

}
