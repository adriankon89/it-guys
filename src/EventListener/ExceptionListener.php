<?php

namespace App\EventListener;

use App\Exception\ExceptionHandlerAggregator;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    public function __construct(
        private ExceptionHandlerAggregator $aggregator
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $this->aggregator->handle($event);
    }
}
