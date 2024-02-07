<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\ReviewRepository;
use App\Entity\User;
use App\Repository\GamePlayedRepository;

class GameInfoService
{
    public const NOTE_PRECISION = 0.5;
    private ReviewRepository $reviewRepository;
    private GamePlayedRepository $gamePlayedRepository;

    public function __construct(
        ReviewRepository $reviewRepository,
        GamePlayedRepository $gamePlayedRepository
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->gamePlayedRepository = $gamePlayedRepository;
    }

    public function getGlobalNote(Game $game): float
    {
        if (empty($this->reviewRepository->findBy(['game' => $game]))) {
            return -0.5;
        }
        $globalNote = 0;

        foreach ($this->reviewRepository->findBy(['game' => $game]) as $review) {
            $globalNote += $review->getNote();
        }
        return round(
            $globalNote / count($this->reviewRepository->findBy(['game' => $game])) / self::NOTE_PRECISION
        ) * self::NOTE_PRECISION;
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
