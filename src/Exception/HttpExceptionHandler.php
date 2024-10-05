<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final readonly class HttpExceptionHandler implements ExceptionHandler
{
    public function handle(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse([$exception->getMessage()]);
        $response = new JsonResponse([
            'error' => 'HttpException',
            'message' => $exception->getMessage(),
        ], JsonResponse::HTTP_BAD_REQUEST);
        $event->setResponse($response);
    }

    public function supports(\Throwable $throwable): bool
    {
        return true === $throwable instanceof HttpException;
    }

    public function priority(): int
    {
        return 20;
    }

}
