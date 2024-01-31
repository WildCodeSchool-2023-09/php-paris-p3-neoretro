<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\GamePlayed;
use App\Entity\User;
use Faker\Factory;

class GamePlayedService
{
    public const EXPERIENCE_COEFFICIENT = 0.8;
    public const LEVEL_EXPERIENCE_TIER = 800;
    public const TOKEN_PER_LEVEL = 10;
    private int $nextLevel = 0;

    public function generate(Game $game, User $user, string $uuid): GamePlayed
    {
        $gamePlayed = new GamePlayed();
        $faker = Factory::create();

        $gamePlayed->setGame($game);
        $gamePlayed->setPlayer($user);
        $gamePlayed->setScore(rand(0, 500));
        $gamePlayed->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year')));
        $gamePlayed->setDuration(rand(120, 1800));
        $gamePlayed->setUuid($uuid);

        return $gamePlayed;
    }

    public function updateExperience(GamePlayed $gamePlayed, User $user): void
    {
        $user->setExperience(
            $user->getExperience() + (int)floor($gamePlayed->getScore() * self::EXPERIENCE_COEFFICIENT)
        );
        $this->nextLevel = $user->getLevel() + 1;
        while ($user->getExperience() >= $this->nextLevel * self::LEVEL_EXPERIENCE_TIER) {
            $user->setExperience($user->getExperience() - ($this->nextLevel) * self::LEVEL_EXPERIENCE_TIER);
            $user->setLevel($this->nextLevel);
            $this->nextLevel = $user->getLevel() + 1;
            $user->setToken($user->getToken() + self::TOKEN_PER_LEVEL);
        }
    }
}
