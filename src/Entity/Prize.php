<?php

namespace App\Entity;

use App\Repository\PrizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrizeRepository::class)]
class Prize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $prizeLabel = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'prizes')]
    private Collection $winners;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->winners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrizeLabel(): ?string
    {
        return $this->prizeLabel;
    }

    public function setPrizeLabel(string $prizeLabel): static
    {
        $this->prizeLabel = $prizeLabel;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getWinners(): Collection
    {
        return $this->winners;
    }

    public function addWinner(User $user): static
    {
        if (!$this->winners->contains($user)) {
            $this->winners->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->winners->removeElement($user);

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
