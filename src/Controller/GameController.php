<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSearchType;
use App\Repository\CategoryRepository;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/game', 'game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        GameRepository $gameRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        $searchForm = $this->createForm(GameSearchType::class);
        $searchForm->handleRequest($request);

        $params = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $params = $searchForm->getData();
        }

        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->search($params),
            'pageTitle' => 'Games',
            'params' => $params,
            'categories' => $categoryRepository->findBy([], ['label' => 'ASC']),
            'searchForm' => $searchForm,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Game $game, GamePlayedRepository $gamePlayedRepository, Security $security): Response
    {
        $user = $security->getUser();
        $gamesPlayed = $gamePlayedRepository->findBestScoresByGame($game->getId());
        $userGamePlayed = $gamePlayedRepository->findPersonalBestByGame($user->getId(), $game->getId());

        return $this->render('game/show.html.twig', [
            'pageTitle' => 'Game',
            'user' => $user,
            'game' => $game,
            'gamesPlayed' => $gamesPlayed,
            'userGamePlayed' => $userGamePlayed
        ]);
    }

    #[Route('/{slug}/scores', name:'scores')]
    public function showScore(
        Game $game,
        Security $security,
        GamePlayedRepository $gamePlayedRepository
    ): Response {
        $user = $security->getUser();
        $gamesPlayed = $gamePlayedRepository->findBestScoresByGame($game->getId(), 50);

        return $this->render('game/scores.html.twig', [
            'pageTitle' => 'Scores',
            'game' => $game,
            'user' => $user,
            'gamesPlayed' => $gamesPlayed,
        ]);
    }
}
