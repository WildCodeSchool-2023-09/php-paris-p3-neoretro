<?php

namespace App\DataFixtures;

use App\Entity\GamePicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

use function Symfony\Component\String\u;

class GamePictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        foreach (GameFixtures::DATAS as $game) {
            for ($i = 0; $i < 4; $i++) {
                $gamePicture = new GamePicture();
                $gamePicture->setPicture($faker->imageUrl(787, 740, 'nightlife'));
                $gamePicture->setGame($this->getReference('game_' . u($game)->replace(' ', '_')));
                $manager->persist($gamePicture);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
        ];
    }
}
