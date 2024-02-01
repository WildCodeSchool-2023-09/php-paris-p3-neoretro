<?php

namespace App\Controller;

use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
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
        return $this->render('user/index.html.twig', [
            'pageTitle' => 'My profile'
        ]);
    }

    #[Route('/scores', name: 'scores')]
    public function scores(
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
    ): Response {
        $user = $security->getUser();

        $userGamesPlayed = [];
        if ($this->isGranted('ROLE_USER')) {
            $userGamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId(), 10);
        }
        $globalGamesPlayed = $gamePlayedRepository->findBy([], ['score' => 'DESC'], 50);

        return $this->render('leaderboard/index.html.twig', [
            'pageTitle' => 'Leaderboard',
            'userGamesPlayed' => $userGamesPlayed,
            'globalGamesPlayed' => $globalGamesPlayed,
        ]);
    }
}
