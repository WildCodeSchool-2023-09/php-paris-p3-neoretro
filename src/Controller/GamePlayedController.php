<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GamePlayedRepository;
use App\Service\GamePlayedService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Service\GameInfoService;
use Symfony\Component\Security\Core\Security;

class GamePlayedController extends AbstractController
{
    #[Route('/game-played/{slug}/{uuid}', name: 'game-played_new')]
    public function new(
        Game $game,
        string $uuid,
        GamePlayedService $gamePlayedService,
        GamePlayedRepository $gamePlayedRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        RouterInterface $router
    ): Response {
        if (!$this->getUser()) {
            $session = $requestStack->getSession();
            $session->set(
                '_security.main.target_path',
                $router->generate(
                    'game-played_new',
                    [
                        'slug' => $requestStack->getCurrentRequest()->attributes->get('slug'),
                        'uuid' => $uuid
                    ]
                )
            );

            return $this->redirectToRoute('dashboard');
        }

        $gamePlayed = $gamePlayedService->generate($game, $this->getUser(), $uuid);

        if (!$gamePlayedRepository->findOneBy(['uuid' => $uuid])) {
            $entityManager->persist($gamePlayed);
            $gamePlayedService->updateExperience($gamePlayed, $this->getUser());
            $entityManager->persist($this->getUser());

            $entityManager->flush();
        }

        return $this->render('game_played/new.html.twig', [
            'gamePlayed' => $gamePlayed,
            'pageTitle' => 'Your last game',
            'experienceGained' => (int)floor($gamePlayed->getScore() * GamePlayedService::EXPERIENCE_COEFFICIENT),
        ]);
    }

    #[Route('/leaderboard', name: 'leaderboard')]
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
