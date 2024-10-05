<?php

namespace App\Entity;

use App\Repository\TimeSheetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeSheetRepository::class)]
class TimeSheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $to_date = null;

    #[ORM\ManyToOne(inversedBy: 'timeSheets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ItGuy $itguy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->from_date;
    }

    public function setFromDate(\DateTimeInterface $from_date): static
    {
        $this->from_date = $from_date;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->to_date;
    }

    public function setToDate(?\DateTimeInterface $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }

    public function getItguy(): ?ItGuy
    {
        return $this->itguy;
    }

    public function setItguy(?ItGuy $itguy): static
    {
        $this->itguy = $itguy;

        return $this;
    }
}
