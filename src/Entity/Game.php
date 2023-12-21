<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $poster = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isVirtual = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: GamePicture::class, orphanRemoval: true)]
    private Collection $gamePictures;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'games')]
    private Collection $categories;

    public function __construct()
    {
        $this->gamePictures = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

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

    public function isIsVirtual(): ?bool
    {
        return $this->isVirtual;
    }

    public function setIsVirtual(bool $isVirtual): static
    {
        $this->isVirtual = $isVirtual;

        return $this;
    }

    /**
     * @return Collection<int, GamePicture>
     */
    public function getGamePictures(): Collection
    {
        return $this->gamePictures;
    }

    public function addGamePicture(GamePicture $gamePicture): static
    {
        if (!$this->gamePictures->contains($gamePicture)) {
            $this->gamePictures->add($gamePicture);
            $gamePicture->setGame($this);
        }

        return $this;
    }

    public function removeGamePicture(GamePicture $gamePicture): static
    {
        if ($this->gamePictures->removeElement($gamePicture)) {
            // set the owning side to null (unless already changed)
            if ($gamePicture->getGame() === $this) {
                $gamePicture->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addGame($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeGame($this);
        }

        return $this;
    }
}
