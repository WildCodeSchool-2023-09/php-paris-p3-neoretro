<?php

namespace App\DataFixtures;

use App\Entity\GamePlayed;
use App\Service\GamePlayedService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use function Symfony\Component\String\u;

class GamePlayedFixtures extends Fixture implements DependentFixtureInterface
{
    private GamePlayedService $gamePlayedService;

    public function __construct(GamePlayedService $gamePlayedService)
    {
        $this->gamePlayedService = $gamePlayedService;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            $player = $this->getReference('user_' . $i);

            for ($j = 0; $j < rand(20, 100); $j++) {
                $gamePlayed = new GamePlayed();

                $gamePlayed->setGame(
                    $this->getReference(
                        'game_' . u(GameFixtures::DATA[array_rand(GameFixtures::DATA)])->replace(' ', '_')
                    )
                );

                $gamePlayed
                    ->setPlayer($player)
                    ->setScore(rand(10, 5000));

                $gamePlayed
                    ->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')))
                    ->setDuration(rand(120, 1800));

                $gamePlayed->setUuid($faker->uuid());
                $this->gamePlayedService->updateExperience($gamePlayed, $player);

                $manager->persist($gamePlayed);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
            UserFixtures::class,
        ];
    }
}
