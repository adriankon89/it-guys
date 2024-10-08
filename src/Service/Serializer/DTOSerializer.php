<?php

namespace App\Service\Serializer;

use App\Event\AfterDtoCreatedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class DTOSerializer implements SerializerInterface
{
    private SerializerInterface $serializer;
    private EventDispatcherInterface $eventDispatcher;
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getName();
            },
        ];

        $this->serializer = new Serializer(
            [
                new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d']),
                new ObjectNormalizer(
                    classMetadataFactory: new ClassMetadataFactory(new AttributeLoader(new AttributeLoader())),
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    defaultContext:$defaultContext,
                )],
            [new JsonEncoder()]
        );
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {

        $dto = $this->serializer->deserialize($data, $type, $format, $context);

        $event = new AfterDtoCreatedEvent($dto);
        $this->eventDispatcher->dispatch($event, $event::NAME);

        return $dto;
    }
}
