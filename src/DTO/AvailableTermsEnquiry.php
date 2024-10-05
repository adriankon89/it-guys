<?php

namespace App\DTO;

use App\Entity\ItGuy;
use DateTime;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class AvailableTermsEnquiry implements BaseDtoInterface, AvailableTermsEnquiryInterface
{
    #[Ignore]
    private ?ItGuy $itGuy = null;
    private ?string $location;
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Assert\NotBlank]
    #[Assert\GreaterThan('today')]
    #[Assert\LessThanOrEqual(propertyPath: 'availableTo', message: 'The start date must be before or equal to the end date.')]
    private DateTimeInterface $availableFrom;
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private DateTimeInterface $availableTo;
    private ?string $availableType = null;
    private array $availableDates = [];

    public function getItGuy(): ?ItGuy
    {
        return $this->itGuy;
    }

    public function setItGuy(?ItGuy $itGuy): void
    {
        $this->itGuy = $itGuy;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    public function getAvailableFrom(): DateTimeInterface
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(string $availableFrom): self
    {
        $this->availableFrom = $this->convertToDateTime($availableFrom);

        return $this;
    }

    public function getAvailableDates(): array
    {
        return  $this->availableDates;
    }

    public function setAvailableDates(array $availableDates): self
    {
        $this->availableDates = $availableDates;

        return $this;
    }

    public function addAvailableTerm(DateTimeInterface $availableTerm): self
    {
        array_push($this->availableDates, $availableTerm);

        return $this;
    }

    public function getAvailableType(): ?string
    {
        return $this->availableType;
    }

    public function setAvailableType(?string $availableType): self
    {
        $this->availableType = $availableType;

        return $this;
    }

    public function getAvailableTo(): DateTimeInterface
    {
        return $this->availableTo;
    }

    public function setAvailableTo(string $availableTo): self
    {

        $this->availableTo = $this->convertToDateTime($availableTo);

        return $this;
    }

    private function convertToDateTime(string $date): DateTimeInterface
    {
        try {
            return  new DateTime($date);
        } catch (Exception $e) {
            throw new InvalidArgumentException("Invalid date format provided: {$date}. Error: " . $e->getMessage());
        }
    }
}
