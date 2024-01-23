<?php

namespace App\Entity;

use App\Repository\GamePlayedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamePlayedRepository::class)]
class GamePlayed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'gamesPlayed')]
    private Collection $players;

    #[ORM\ManyToOne(inversedBy: 'gamesPlayed')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\Column]
    private ?int $scorePlayerOne = null;

    #[ORM\Column(nullable: true)]
    private ?int $scorePlayerTwo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?int $duration = null;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(User $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }

        return $this;
    }

    public function removePlayer(User $player): static
    {
        $this->players->removeElement($player);

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

    public function getScorePlayerOne(): ?int
    {
        return $this->scorePlayerOne;
    }

    public function setScorePlayerOne(int $scorePlayerOne): static
    {
        $this->scorePlayerOne = $scorePlayerOne;

        return $this;
    }

    public function getScorePlayerTwo(): ?int
    {
        return $this->scorePlayerTwo;
    }

    public function setScorePlayerTwo(?int $scorePlayerTwo): static
    {
        $this->scorePlayerTwo = $scorePlayerTwo;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
