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
        Request $request,
        Security $security,
        GamePlayedRepository $gamePlayedRepository
    ): Response {
        $searchForm = $this->createForm(GameSearchType::class);
        $searchForm->handleRequest($request);

        $params = [];
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $params = $searchForm->getData();
        }

        $user = null;
        if ($this->isGranted('ROLE_USER')) {
            $user = $security->getUser();
        }

        $games = $gameRepository->search($params, $user->getId());

        if ($this->isGranted('ROLE_USER')) {
            foreach ($games as $gameIndex => $game) {
                $gamesPlayed = $gamePlayedRepository->findBestScoresByGame($game[0]->getId());
                foreach ($gamesPlayed as $rank => $gamePlayed) {
                    if ($gamePlayed->getPlayer()->getId() === $user->getId()) {
                        $games[$gameIndex]['userRanking'] = $rank + 1;
                    }
                }
            }
        }

        return $this->render('game/index.html.twig', [
            'games' => $games,
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

        $userRanking = null;
        if ($this->isGranted('ROLE_USER')) {
            foreach ($gamesPlayed as $rank => $gamePlayed) {
                if ($gamePlayed->getPlayer()->getId() === $user->getId()) {
                    $userRanking = $rank + 1;
                }
            }
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
