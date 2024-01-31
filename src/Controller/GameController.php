<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSearchType;
use App\Repository\CategoryRepository;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use App\Service\ScoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
        Request $request,
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
        ScoreService $scoreService
    ): Response {
        $searchForm = $this->createForm(GameSearchType::class);
        $searchForm->handleRequest($request);
        $params = [
            'isVisible' => 1
        ];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $params = $searchForm->getData();
        }
        if ($this->isGranted('ROLE_USER')) {
            $params['userId'] = $security->getUser()->getId();
        }

        $games = $gameRepository->search($params);
        $games = $scoreService->addUserRankings($games);

        return $this->render('game/index.html.twig', [
            'games' => $games,
            'pageTitle' => 'Games',
            'categories' => $categoryRepository->findBy([], ['label' => 'ASC']),
            'searchForm' => $searchForm,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Game $game, GamePlayedRepository $gamePlayedRepository, Security $security): Response
    {
        $user = $security->getUser();
        $gamesPlayed = $gamePlayedRepository->findBestScoresByGame($game->getId());

        $userRanking = null;
        $userGamePlayed = null;

        if ($this->isGranted('ROLE_USER')) {
            foreach ($gamesPlayed as $rank => $gamePlayed) {
                if ($gamePlayed->getPlayer()->getId() === $user->getId()) {
                    $userRanking = $rank + 1;
                }
            }
            $userGamePlayed = $gamePlayedRepository->findPersonalBestByGame($user->getId(), $game->getId());
        }

        return $this->render('game/show.html.twig', [
            'pageTitle' => 'Game',
            'game' => $game,
            'gamesPlayed' => $gamesPlayed,
            'userGamePlayed' => $userGamePlayed,
            'userRanking' => $userRanking,
        ]);
    }

    #[Route('/{slug}/scores', name:'scores')]
    public function showScore(
        Game $game,
        Security $security,
        GamePlayedRepository $gamePlayedRepository
    ): Response {
        $gamesPlayed = $gamePlayedRepository->findBestScoresByGame($game->getId(), 50);

        return $this->render('game/scores.html.twig', [
            'pageTitle' => 'Scores',
            'game' => $game,
            'gamesPlayed' => $gamesPlayed,
        ]);
    }
}
