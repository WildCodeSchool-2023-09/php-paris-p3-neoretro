<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

use function Symfony\Component\String\u;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        foreach (GameFixtures::DATA as $game) {
            for ($i = 0; $i < 6; $i++) {
                $picture = new Picture();
                $picture->setFileName($faker->imageUrl(787, 740, 'nightlife'));
                $picture->setGame($this->getReference('game_' . u($game)->replace(' ', '_')));
                $manager->persist($picture);
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
