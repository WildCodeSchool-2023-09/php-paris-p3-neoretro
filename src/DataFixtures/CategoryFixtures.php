<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function Symfony\Component\String\u;

class CategoryFixtures extends Fixture
{
    public const DATA = [
        'Flipper',
        'Machine',
        'Shooter',
        'Action',
        'Aventure',
        'Strategy',
        'Sci-Fi',
        'Fantasy',
        'Survival',
        'Horror',
        'Race'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $data) {
            $category = new Category();
            $category->setLabel($data);
            $manager->persist($category);
            $this->addReference('category_' . u($category->getLabel())->replace(' ', '_'), $category);
        }

        $manager->flush();
    }
}
