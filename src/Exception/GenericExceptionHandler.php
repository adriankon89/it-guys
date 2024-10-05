<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class GenericExceptionHandler implements ExceptionHandler
{
    public function handle(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'error' => 'GenericException',
            'message' => $exception->getMessage(),
        ], JsonResponse::HTTP_BAD_REQUEST);
        $event->setResponse($response);
    }

    public function supports(\Throwable $throwable): bool
    {
        return true;
    }

    public function priority(): int
    {
        return 10;
    }

}
