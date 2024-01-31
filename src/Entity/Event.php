<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Game $game = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\ManyToOne(inversedBy: 'secondPrize')]
    private ?Prize $firstPrize = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Prize $secondPrize = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Prize $thirdPrize = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function isIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getFirstPrize(): ?Prize
    {
        return $this->firstPrize;
    }

    public function setFirstPrize(?Prize $firstPrize): static
    {
        $this->firstPrize = $firstPrize;

        return $this;
    }

    public function getSecondPrize(): ?Prize
    {
        return $this->secondPrize;
    }

    public function setSecondPrize(?Prize $secondPrize): static
    {
        $this->secondPrize = $secondPrize;

        return $this;
    }

    public function getThirdPrize(): ?Prize
    {
        return $this->thirdPrize;
    }

    public function setThirdPrize(?Prize $thirdPrize): static
    {
        $this->thirdPrize = $thirdPrize;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
