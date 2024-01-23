<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSearchType;
use App\Form\GameType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'pageTitle' => 'Game',
            'game' => $game,
        ]);
    }

    #[Route('/{slug}/scores', name:'scores')]
    public function showScore(Game $game, Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('game/scores.html.twig', [
            'pageTitle' => 'Scores',
            'game' => $game,
            'user' => $user
        ]);
    }
}
