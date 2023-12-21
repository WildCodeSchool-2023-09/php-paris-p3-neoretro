<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function Symfony\Component\String\u;

class CategoryFixtures extends Fixture
{
    public const DATAS = [
        'Jeu vidéo',
        'Flipper',
        'Machine attrape-peluche',
        'Jeu de rachat',
        'Action',
        'Aventure',
        'VR',
        'Science-fiction',
        'Fantasy'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATAS as $data) {
            $category = new Category();
            $category->setLabel($data);
            $manager->persist($category);
            $this->addReference('category_' . u($category->getLabel())->replace(' ', '_'), $category);
        }

        $manager->flush();
    }
}
