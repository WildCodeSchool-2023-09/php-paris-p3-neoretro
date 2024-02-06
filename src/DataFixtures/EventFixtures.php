<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

use function Symfony\Component\String\u;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            $event = new Event();

            $event
                ->setLabel($faker->word())
                ->setDescription($faker->paragraph())
                ->setGame($this->getReference(
                    'game_' . u(GameFixtures::DATA[array_rand(GameFixtures::DATA)])->replace(' ', '_')
                ))
                ->setIsVisible(rand(0, 1) ? true : false)
                ->setSlug($this->slugger->slug($event->getLabel()));
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
            UserFixtures::class
        ];
    }
}
