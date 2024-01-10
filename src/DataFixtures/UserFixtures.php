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
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($this->faker->userName);
            $user->setFirstname($this->faker->firstName);
            $user->setLastname($this->faker->lastName);
            $user->setEmail($this->faker->text(20));
            $user->setPhoneNumber($this->faker->numberBetween(1000000000, 9999999999));;
            $user->setRoles([]);
            $user->setToken($this->faker->numberBetween(1000, 9999));
            $zipcode = $this->faker->regexify('[0-9]{5}'); // Génère un code postal de 5 chiffres.
            $user->setZipcode($zipcode);
            $user->setAdress($this->faker->streetAddress);
            $user->setCity($this->faker->city);
            $user->setExperience($this->faker->numberBetween(1, 10));
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password123'));
            $manager->persist($user);
        }

            $admin = new User();
            $admin->setUsername($this->faker->userName);
            $admin->setFirstname($this->faker->firstName);
            $admin->setLastname($this->faker->lastName);
            $admin->setEmail($this->faker->text(20));
            $admin->setPhonenumber($this->faker->numberBetween(1000000000, 9999999999));
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setToken($this->faker->numberBetween(1000, 9999));
            $zipcode = $this->faker->regexify('[0-9]{5}'); // Génère un code postal de 5 chiffres.
            $admin->setZipcode($zipcode);
            $admin->setAdress($this->faker->streetAddress);
            $admin->setCity($this->faker->city);
            $admin->setExperience($this->faker->numberBetween(1, 10));
            $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'admin123'));
            $manager->persist($admin);

            $manager->flush();
    }
}
