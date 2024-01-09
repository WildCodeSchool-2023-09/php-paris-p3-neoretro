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
            $prize->setPrizeLabel($data);
            $prize->setDescription($faker->text());
            $prize->setPicture($faker->imageUrl(365, 240, 'nightlife'));
            $prize->setValue(100);
            $prize->setQuantity(10);
            $prize->setSlug($this->slugger->slug($prize->getPrizeLabel()));
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
