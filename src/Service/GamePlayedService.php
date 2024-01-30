<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\GamePlayed;
use App\Entity\User;
use Faker\Factory;

class GamePlayedService
{
    public function generate(Game $game, User $user): GamePlayed
    {
        $gamePlayed = new GamePlayed();
        $faker = Factory::create();

        $gamePlayed->setGame($game);
        $gamePlayed->setPlayer($user);
        $gamePlayed->setScore(rand(0, 500));
        $gamePlayed->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));
        $gamePlayed->setDuration(rand(120, 1800));

        return $gamePlayed;
    }
}
