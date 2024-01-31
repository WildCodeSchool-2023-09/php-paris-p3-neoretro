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
        'Metroid 3',
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
        'Shooter Master',
    ];

    public const POSTERS = [
        '/images/game-posters/metroid.jpeg',
        '/images/game-posters/racecar.jpeg',
        '/images/game-posters/space-invaders.png',
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
            $game->setSlug($this->slugger->slug($game->getTitle()));

            for ($i = 0; $i < 2; $i++) {
                $game->addCategory(
                    $this->getReference('category_' . u(CategoryFixtures::DATA[rand(0, 8)])->replace(' ', '_'))
                );
            }

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
