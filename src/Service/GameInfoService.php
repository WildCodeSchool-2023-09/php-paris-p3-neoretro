<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\GamePlayedRepository;

class GameInfoService
{
    private GamePlayedRepository $gamePlayedRepository;

    public function __construct(GamePlayedRepository $gamePlayedRepository)
    {
        $this->gamePlayedRepository = $gamePlayedRepository;
    }

    public function getUserGamesStats(array $games, User $user): array
    {
        $gamesStats = [];

        foreach ($games as $game) {
            $gamesPlayed = $this->gamePlayedRepository->findBy([
                'game' => $game,
                'player' => $user,
            ]);

            $gamesStats[$game->getId()] = [];

            if (!empty($gamesPlayed)) {
                $gamesStats[$game->getId()]['totalTimePlayed'] = $this
                    ->formatTime($this->gamePlayedRepository->findTotalTimePlayed(
                        $game->getId(),
                        $user->getId()
                    )['totalTimePlayed']);

                $gamesPlayed = $this->gamePlayedRepository->findGlobalBestScoresByGame($game->getId());

                foreach ($gamesPlayed as $rank => $gamePlayed) {
                    if ($gamePlayed->getPlayer()->getId() === $user->getId()) {
                        $gamesStats[$game->getId()]['userRanking'] = $rank + 1;
                    }
                }

                $gamesStats[$game->getId()]['personalBestScore'] = $this
                    ->gamePlayedRepository->findPersonalBestScoreByGame(
                        $game->getId(),
                        $user->getId()
                    )['score'];
            }
        }

        // dump($gamesStats);die();
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
