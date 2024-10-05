<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class NotFoundExceptionHandler implements ExceptionHandler
{
    public function handle(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'error' => 'Resource not found',
            'message' => $exception->getMessage(),
        ], JsonResponse::HTTP_NOT_FOUND);
        $event->setResponse($response);

    }

    public function supports(\Throwable $throwable): bool
    {
        return true === $throwable instanceof NotFoundHttpException;
    }

    public function priority(): int
    {
        return 120;
    }

}
