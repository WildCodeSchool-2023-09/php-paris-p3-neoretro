<?php

namespace App\DataFixtures;

use App\Entity\Prize;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory as Faker;

use function Symfony\Component\String\u;

class PrizeFixtures extends Fixture implements DependentFixtureInterface
{
    public const DATAS = [
        'Peluche',
        'Clé USB',
        'Porte Clé',
        'Sac à dos',
        'Mug',
        'Console',
        'Manette PS5',
        'Carte Cadeaux',
    ];

    public const PICTURES = [
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

        foreach (self::DATAS as $data) {
            $prize = new Prize();
            $prize->setLabel($data);
            $prize->setDescription($faker->text());
            $prize->setPicture(self::PICTURES[array_rand(self::PICTURES)]);
            $prize->setValue(100);
            $prize->setQuantity(10);
            $prize->setSlug($this->slugger->slug($prize->getLabel()));
            $manager->persist($prize);
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
