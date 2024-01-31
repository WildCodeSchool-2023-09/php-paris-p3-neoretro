<?php

namespace App\Service;

use App\Repository\GamePlayedRepository;

class ScoreService
{
    private GamePlayedRepository $gamePlayedRepository;

    public function __construct(GamePlayedRepository $gamePlayedRepository)
    {
        $this->gamePlayedRepository = $gamePlayedRepository;
    }

    public function addUserRankings(array $games, int $userId = null): array
    {
        if (!is_null($userId)) {
            foreach ($games as $gameIndex => $game) {
                $gamesPlayed = $this->gamePlayedRepository->findBestScoresByGame($game[0]->getId());
                foreach ($gamesPlayed as $rank => $gamePlayed) {
                    if ($gamePlayed->getPlayer()->getId() === $userId) {
                        $games[$gameIndex]['userRanking'] = $rank + 1;
                    }
                }
            }
        }

        return $games;
    }
}
