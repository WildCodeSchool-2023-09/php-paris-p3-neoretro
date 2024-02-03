<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator as FakerGenerator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private FakerGenerator $faker;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = new User();

            switch ($i) {
                case 1:
                    $user
                        ->setUsername('admin')
                        ->setPassword($this->userPasswordHasher->hashPassword($user, 'admin'))
                        ->setRoles(['ROLE_ADMIN']);
                    break;
                case 2:
                    $user
                        ->setUsername('user')
                        ->setPassword($this->userPasswordHasher->hashPassword($user, 'user'))
                        ->setRoles(['ROLE_USER']);
                    break;
                default:
                    $user
                        ->setUsername($this->faker->userName())
                        ->setPassword('pass1234')
                        ->setRoles(['ROLE_USER']);
                    break;
            }

            $user
                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setPhoneNumber($this->faker->e164PhoneNumber())
                ->setToken($this->faker->numberBetween(0, 200))
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
