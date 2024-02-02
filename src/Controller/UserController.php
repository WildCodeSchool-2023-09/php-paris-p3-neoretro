<?php

namespace App\Controller;

use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use App\Service\GameInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard', []);
        }

        return $this->render('user/index.html.twig', [
            'pageTitle' => 'My profile'
        ]);
    }

    #[Route('/scores', name: 'scores')]
    public function scores(
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
        GameInfoService $gameInfoService
    ): Response {
        $user = $security->getUser();

        if ($this->isGranted('ROLE_USER')) {
            $userGamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId(), 10);

            $userGamesStats = [];
            foreach ($userGamesPlayed as $userGamePlayed) {
                $userGamesStats[] = $gameInfoService->formatTime($userGamePlayed->getDuration(), 'short');
            }
        }

        $globalGamesPlayed = $gamePlayedRepository->findBy([], ['score' => 'DESC'], 50);
        $globalGamesStats = [];
        foreach ($globalGamesPlayed as $globalGamePlayed) {
            $globalGamesStats[] = $gameInfoService->formatTime($globalGamePlayed->getDuration(), 'short');
        }

        return $this->render('leaderboard/index.html.twig', [
            'pageTitle' => 'Leaderboard',
            'userGamesPlayed' => $userGamesPlayed ?? [],
            'userGamesStats' => $userGamesStats ?? [],
            'globalGamesPlayed' => $globalGamesPlayed,
            'globalGamesStats' => $globalGamesStats,
        ]);
    }
}
