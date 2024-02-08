<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSearchType;
use App\Form\GameFormType;
use App\Repository\CategoryRepository;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use App\Repository\ReviewRepository;
use App\Service\GameInfoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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
        GameInfoService $gameInfoService
    ): Response {
        $searchForm = $this->createForm(GameSearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $params = $searchForm->getData();
        }

        $games = $gameRepository->search($params ?? []);

        if ($this->isGranted('ROLE_USER')) {
            $gamesStats = $gameInfoService->getUserGamesStats($games, $security->getUser());
        }

        return $this->render('game/index.html.twig', [
            'games' => $games,
            'gamesStats' => $gamesStats ?? [],
            'pageTitle' => 'Games',
            //'categories' => $categoryRepository->findBy([], ['label' => 'ASC']),
            'searchForm' => $searchForm,
            'params' => $params ?? ['isVisible' => 1],
        ]);
    }

    #[Route('/new', name: 'new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $game = new Game();

        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($game->getTitle()) {
                    $slug = $slugger->slug($game->getTitle());
                    $game->setSlug($slug);
                }

                $entityManager->persist($game);
                $entityManager->flush();

                $this->addFlash("Success", "The game has been added!");

                return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
            } else {
                foreach ($form->getErrors(true, true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        return $this->render('game/new.html.twig', [
            'gameForm' => $form,
            'pageTitle' => 'Add game',
        ]);
    }

    #[Route('/mini-game/breakout', name:'mini-game')]
    public function play(): Response
    {
        return $this->render('game/mini-game/breakout.html.twig');
    }

    #[Route('/{slug}', name: 'show')]
    public function show(
        Game $game,
        GamePlayedRepository $gamePlayedRepository,
        ReviewRepository $reviewRepository,
        Security $security,
        GameInfoService $gameInfoService
    ): Response {
        $user = $security->getUser();
        $gamesPlayed = $gamePlayedRepository->findGlobalBestScoresByGame($game->getId());

        if ($this->isGranted('ROLE_USER')) {
            $gameStats = $gameInfoService->getUserGamesStats([$game], $user)[$game->getId()];
        }

        return $this->render('game/show.html.twig', [
            'pageTitle' => 'Game',
            'game' => $game,
            'gameStats' => $gameStats ?? [],
            'gamesPlayed' => $gamesPlayed,
            'reviews' => $reviewRepository->findBy(['game' => $game]),
            'globalNote' => $gameInfoService->getGlobalNote($game),
        ]);
    }

    #[Route('/{slug}/scores', name: 'scores')]
    public function showScores(
        Game $game,
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
        GameInfoService $gameInfoService
    ): Response {
        $gamesPlayed = $gamePlayedRepository->findGlobalBestScoresByGame($game->getId(), 50);

        $gamesStats = [];
        foreach ($gamesPlayed as $gamePlayed) {
            $gamesStats[] = $gameInfoService->formatTime($gamePlayed->getDuration(), 'short');
        }

        return $this->render('game/scores.html.twig', [
            'pageTitle' => 'Scores',
            'game' => $game,
            'gamesPlayed' => $gamesPlayed,
            'gamesStats' => $gamesStats,
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Game $game,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $form = $this->createForm(GameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors(true, true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash("Success", "The game has been edited");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/edit.html.twig', [
            'gameForm' => $form,
            'pageTitle' => 'Edit game',
        ]);
    }
}
