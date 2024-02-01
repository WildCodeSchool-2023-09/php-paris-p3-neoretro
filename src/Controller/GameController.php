<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSearchType;
use App\Form\GameFormType;
use App\Repository\CategoryRepository;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use App\Service\ScoreService;
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
        Request $request,
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
        ScoreService $scoreService
    ): Response {
        $searchForm = $this->createForm(GameSearchType::class);
        $searchForm->handleRequest($request);
        $params = [
            'isVisible' => 1,
            'userId' => null,
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

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $game = new Game();

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($game->getTitle()) {
                $slug = $slugger->slug($game->getTitle());
                $game->setSlug($slug);
            }

            $entityManager->persist($game);
            $entityManager->flush();

            // $this->addFlash("Success", "The game has been added");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new_game.html.twig', [
            'gameForm' => $form,
            'pageTitle' => 'Add game',
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // $this->addFlash("Success", "The game has been edited");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'gameForm' => $form,
            'pageTitle' => 'Edit game',
        ]);
    }
}
