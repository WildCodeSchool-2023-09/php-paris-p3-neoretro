<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory as Faker;

use function Symfony\Component\String\u;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public const DATA = [
        'Super Metroid',
        'Out Run',
        'Midnight Race',
        'Tower Defense',
        'Pacman',
        'Duke Nukem',
        'Renegade',
        'Tetris',
        'Space Invaders',
        'Kung-fu Master',
        'Zombie Killers',
        'Ninja Spirits',
        'Factory Madness',
        'Metal Slug',
    ];

    public const POSTERS = [
        'metroid.jpeg',
        'racecar.jpeg',
        'space-invaders.png',
        'duke-nukem.jpg',
        'metal-slug.jpg',
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        foreach (self::DATA as $data) {
            $game = new Game();
            $game->setTitle($data);
            $game->setDescription($faker->text());
            $game->setPoster(self::POSTERS[array_rand(self::POSTERS)]);
            $game->setIsVirtual(false);
            $game->setIsVisible(true);
            $game->setSlug($this->slugger->slug($game->getTitle()));
            $game->setMainCategory(
                $this->getReference('category_' . u(CategoryFixtures::DATA[rand(0, 8)])->replace(' ', '_'))
            );
            $game->setOptionalCategory(
                $this->getReference('category_' . u(CategoryFixtures::DATA[rand(0, 8)])->replace(' ', '_'))
            );

            $manager->persist($game);
            $this->addReference('game_' . u($data)->replace(' ', '_'), $game);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
