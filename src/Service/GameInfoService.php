<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\ReviewRepository;

class GameInfoService
{
    public const NOTE_PRECISION = 0.5;
    private ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
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
}
