<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator as FakerGenerator;

class UserFixtures extends Fixture
{
    private FakerGenerator $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = new User();

            if ($i === 1) {
                $user
                    ->setUsername('admin')
                    ->setPassword('admin')
                    ->setRoles(['ROLE_ADMIN'])
                    ->setToken($this->faker->numberBetween(1000, 9999));
            } else {
                $user
                    ->setUsername($this->faker->userName())
                    ->setPassword('pass1234')
                    ->setRoles(['ROLE_USER'])
                    ->setToken($this->faker->numberBetween(0, 200));
            }

            $user
                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())

                ->setEmail($this->faker->email())
                ->setPhoneNumber($this->faker->e164PhoneNumber())

                ->setZipcode($this->faker->regexify('[0-9]{5}'))
                ->setAdress($this->faker->streetAddress())
                ->setCity($this->faker->city())

                ->setExperience($this->faker->numberBetween(0, 500));

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
