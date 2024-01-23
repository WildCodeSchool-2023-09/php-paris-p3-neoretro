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
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 1000; $i++) {
            $gamePlayed = new GamePlayed();
            $faker = Factory::create();

            $gamePlayed->setGame(
                $this->getReference('game_' . u(GameFixtures::DATA[array_rand(GameFixtures::DATA)])->replace(' ', '_'))
            );

            $gamePlayed
                ->addPlayer($this->getReference('user_' . rand(1, 20)))
                ->setScorePlayerOne(rand(0, 500));

            if (rand(0, 1)) {
                $gamePlayed
                    ->addPlayer($this->getReference('user_' . rand(1, 20)))
                    ->setScorePlayerTwo(rand(0, 500));
            }

            $gamePlayed
                ->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')))
                ->setDuration(rand(120, 1800));

            $manager->persist($gamePlayed);
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
