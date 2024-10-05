<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

interface ExceptionHandler
{
    public function handle(ExceptionEvent $event): void;

    public function supports(Throwable $throwable): bool;

    public function priority(): int;

}
