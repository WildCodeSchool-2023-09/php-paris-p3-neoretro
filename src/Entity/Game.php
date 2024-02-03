<?php

namespace App\Entity;

use DateTimeInterface;
use App\Entity\Category;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[Vich\UploadableField(mapping: 'poster_file', fileNameProperty: 'poster')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $posterFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updateAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isVirtual = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isVisible = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Picture::class, orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'games')]
    private Collection $categories;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: GamePlayed::class)]
    private Collection $gamesPlayed;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->gamesPlayed = new ArrayCollection();
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

    public function setPoster(?string $poster): static
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

    public function isIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setGame($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getGame() === $this) {
                $picture->setGame(null);
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    public function setPosterFile(File $image = null): Game
    {
        $this->posterFile = $image;
        if ($image) {
            $this->updateAt = new DateTime('now');
        }
        return $this;
    }

    public function getUpdateAt(): ?DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?DateTimeInterface $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection<int, GamePlayed>
     */
    public function getGamesPlayed(): Collection
    {
        return $this->gamesPlayed;
    }

    public function addGamesPlayed(GamePlayed $gamesPlayed): static
    {
        if (!$this->gamesPlayed->contains($gamesPlayed)) {
            $this->gamesPlayed->add($gamesPlayed);
            $gamesPlayed->setGame($this);
        }

        return $this;
    }

    public function removeGamesPlayed(GamePlayed $gamesPlayed): static
    {
        if ($this->gamesPlayed->removeElement($gamesPlayed)) {
            // set the owning side to null (unless already changed)
            if ($gamesPlayed->getGame() === $this) {
                $gamesPlayed->setGame(null);
            }
        }

        return $this;
    }
}
