<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\GamePlayedRepository;

class GameInfoService
{
    private GamePlayedRepository $gamePlayedRepository;

    public function __construct(GamePlayedRepository $gamePlayedRepository)
    {
        $this->gamePlayedRepository = $gamePlayedRepository;
    }

    public function getUserGamesStats(array $games, int $userId): array
    {
        $gamesStats = [];
        foreach ($games as $gameIndex => $game) {
            if (
                !$this->gamePlayedRepository->findBy(
                    [
                        'game' => $game->getId(),
                        'player' => $userId
                    ],
                    null,
                    1
                )
            ) {
                $gamesStats[$gameIndex] = null;
            } else {
                $gamesStats[$gameIndex]['totalTimePlayed'] = $this
                    ->formatTime($this->gamePlayedRepository->findTotalTimePlayed(
                        $game->getId(),
                        $userId
                    )['totalTimePlayed']);

                $gamesPlayed = $this->gamePlayedRepository->findGlobalBestScoresByGame($game->getId());
                foreach ($gamesPlayed as $rank => $gamePlayed) {
                    if ($gamePlayed->getPlayer()->getId() === $userId) {
                        $gamesStats[$gameIndex]['userRanking'] = $rank + 1;
                    }
                }

                $gamesStats[$gameIndex]['personalBestScore'] = $this
                    ->gamePlayedRepository->findPersonalBestScoreByGame(
                        $game->getId(),
                        $userId
                    )['score'];
            }
        }

        return $gamesStats;
    }

    public function formatTime(int $seconds, string $format = 'long'): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secondsLeft = $seconds % 60;

        if ($format === 'short') {
            return sprintf("%02d'%02d\"", $minutes, $secondsLeft);
        }

        $timeString = '';
        if ($hours > 0) {
            $timeString .= $hours . 'h';
        }
        if ($minutes > 0 || $hours == 0) {
            $timeString .= sprintf("%02dmin", $minutes);
        }

        return $timeString;
    }
}
