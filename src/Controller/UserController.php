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
        $gamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId());

        return $this->render('user/scores.html.twig', [
            'pageTitle' => 'Leaderboard',
            'user' => $user,
            'gamesPlayed' => $gamesPlayed,
        ]);
    }
}
