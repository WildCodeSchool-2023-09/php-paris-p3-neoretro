<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('wissal');
        $user->setFirstname('wissallu');
        $user->setLastname('kerkour');
        $user->setEmail('wsskerkour@gmail.com');
        $user->setPhonenumber('0763571012');
        $user->setRoles([]);
        $user->setToken(3);
        $user->setZipcode('78190');
        $user->setAdress('danslsepthuit');
        $user->setCity('city');
        $user->setExperience(3);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, '1234'));
        $manager->persist($user);

        $manager->flush();
    }
}
