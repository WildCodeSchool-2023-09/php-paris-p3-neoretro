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
        $user
            ->setUsername('testuser')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'testuser'))

            ->setFirstname($this->faker->firstName())
            ->setLastname($this->faker->lastName())

            ->setEmail($this->faker->email())
            ->setPhoneNumber($this->faker->e164PhoneNumber())

            ->setRoles(['ROLE_USER'])
            ->setToken($this->faker->numberBetween(0, 200))

            ->setZipcode($this->faker->regexify('[0-9]{5}'))
            ->setAdress($this->faker->streetAddress())
            ->setCity($this->faker->city())

            ->setExperience($this->faker->numberBetween(0, 500));

        $this->addReference('user_test', $user);
        $manager->persist($user);

        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user
                ->setUsername($this->faker->userName())
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'pass1234'))

                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())

                ->setEmail($this->faker->email())
                ->setPhoneNumber($this->faker->e164PhoneNumber())

                ->setRoles(['ROLE_USER'])
                ->setToken($this->faker->numberBetween(0, 200))

                ->setZipcode($this->faker->regexify('[0-9]{5}'))
                ->setAdress($this->faker->streetAddress())
                ->setCity($this->faker->city())

                ->setExperience($this->faker->numberBetween(0, 500));

            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $admin = new User();
        $admin
            ->setUsername('admin')
            ->setPassword($this->userPasswordHasher->hashPassword($admin, 'admin'))

            ->setRoles(['ROLE_ADMIN'])
            ->setToken($this->faker->numberBetween(1000, 9999))

            ->setFirstname($this->faker->firstName)
            ->setLastname($this->faker->lastName)

            ->setEmail($this->faker->text(20))
            ->setPhonenumber($this->faker->text(10))

            ->setZipcode($this->faker->regexify('[0-9]{5}'))
            ->setAdress($this->faker->streetAddress)
            ->setCity($this->faker->city)

            ->setExperience($this->faker->numberBetween(1, 10));

        $manager->persist($admin);
        $manager->flush();
    }
}
