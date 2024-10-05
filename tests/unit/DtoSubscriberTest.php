<?php

namespace App\Tests\unit;

use App\DTO\AvailableTermsEnquiry;
use App\Tests\ServiceTestCase;
use App\Exception\ServiceException;
use App\Event\AfterDtoCreatedEvent;
use App\EventSubscriber\DtoSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DtoSubscriberTest extends ServiceTestCase
{
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(AfterDtoCreatedEvent::NAME, DtoSubscriber::getSubscribedEvents());
    }

    public function testValidateDto(): void
    {
        $dto = new AvailableTermsEnquiry();
        $event = new AfterDtoCreatedEvent($dto);
        $dispatcher = $this->container->get(EventDispatcherInterface::class);

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('ConstraintViolationList');

        $dispatcher->dispatch($event, $event::NAME);
    }
}
