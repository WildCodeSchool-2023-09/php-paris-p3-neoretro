<?php

namespace App\Service;

use App\Entity\GamePlayed;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Faker\Factory;

class GamePlayedService
{
    private GameRepository $gameRepository;
    private UserRepository $userRepository;

    public function __construct(GameRepository $gameRepository, UserRepository $userRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->userRepository = $userRepository;
    }

    public function generate(): GamePlayed
    {
        $gamePlayed = new GamePlayed();
        $faker = Factory::create();

        $games = $this->gameRepository->findAll();
        $gamePlayed->setGame($games[array_rand($games)]);

        $players = $this->userRepository->findAll();
        $gamePlayed
            ->setPlayer($players[array_rand($players)])
            ->setScore(rand(0, 500));

        $gamePlayed
            ->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')))
            ->setDuration(rand(120, 1800));

        return $gamePlayed;
    }
}
