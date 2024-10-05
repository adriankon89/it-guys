<?php

declare(strict_types=1);

namespace App\Tests\DTO;

use App\DTO\AvailableTermsEnquiry;
use App\Event\AfterDtoCreatedEvent;
use App\Exception\ServiceException;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class AvailableTermsEnquiryValidationTest extends KernelTestCase
{
    private SerializerInterface $serializer;
    private EventDispatcherInterface $dispatcher;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->serializer = static::getContainer()->get(SerializerInterface::class);
        $this->dispatcher = static::getContainer()->get(EventDispatcherInterface::class);
    }

    public function testSetAvailableFromValidDate(): void
    {
        $dto = new AvailableTermsEnquiry();
        $dto->setAvailableFrom('2024-10-10');

        $this->assertInstanceOf(\DateTimeInterface::class, $dto->getAvailableFrom());
        $this->assertEquals('2024-10-10', $dto->getAvailableFrom()->format('Y-m-d'));
    }

    public function testSetAvailableFromInvalidDate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid date format provided');

        $dto = new AvailableTermsEnquiry();
        $dto->setAvailableFrom('20aa24-10-10');
    }

    public function testAvailableFromIsLessThanAvailableTo(): void
    {
        $data = [
            'availableFrom' => '2024-10-10',
            'availableTo' => '2023-10-10'
        ];

        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('ConstraintViolationList');

        $dto = $this->serializer->deserialize(json_encode($data), AvailableTermsEnquiry::class, 'json');
        $event = new AfterDtoCreatedEvent($dto);

        $this->dispatcher->dispatch($event, $event::NAME);
    }

}
