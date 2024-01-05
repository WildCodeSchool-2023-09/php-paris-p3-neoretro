<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Faker\Generator as FakerGenerator;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private FakerGenerator $faker;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername($this->faker->userName);
        $user->setFirstname($this->faker->firstName);
        $user->setLastname($this->faker->lastName);
        $user->setEmail($this->faker->email);
        $user->setPhonenumber($this->faker->phoneNumber);
        $user->setRoles([]);
        $user->setToken($this->faker->randomNumber(2));
        $user->setZipcode($this->faker->postcode);
        $user->setAdress($this->faker->streetAddress);
        $user->setCity($this->faker->city);
        $user->setExperience($this->faker->randomNumber(1));
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername($this->faker->userName);
        $admin->setFirstname($this->faker->firstName);
        $admin->setLastname($this->faker->lastName);
        $admin->setEmail($this->faker->email);
        $admin->setPhonenumber($this->faker->phoneNumber);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setToken($this->faker->randomNumber(2));
        $admin->setZipcode($this->faker->postcode);
        $admin->setAdress($this->faker->streetAddress);
        $admin->setCity($this->faker->city);
        $admin->setExperience($this->faker->randomNumber(1));
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $manager->flush();
    }
}
