<?php

namespace App\Event;

use App\DTO\AvailableTermsEnquiryInterface;
use App\DTO\BaseDtoInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterDtoCreatedEvent extends Event
{
    public const NAME = 'dto.created';

    public function __construct(protected BaseDtoInterface $dto)
    {
    }

    public function getDto(): BaseDtoInterface
    {
        return $this->dto;
    }
}
