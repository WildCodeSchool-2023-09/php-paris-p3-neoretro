<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/game', 'game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GameRepository $gameRepository, CategoryRepository $categoryRepository): Response
    {
        $title = '';

        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->search([
                'title' => $title,
                'category' => [],
                'sort' => [
                    'criteria' => 'g.title',
                    'order' => 'DESC'
                ]]),
            'pageTitle' => 'Games',
            'title' => $title,
            'categories' => $categoryRepository->findBy([], ['label' => 'ASC'])
        ]);
    }

    #[Route('/new', name: 'game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($game->getTitle());
            $game->setSlug($slug);
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form,
            'pageTitle' => 'Game',
        ]);
    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'pageTitle' => 'Game',
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Game $game,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($game->getTitle());
            $game->setSlug($slug);
            $entityManager->flush();

            return $this->redirectToRoute('game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
            'pageTitle' => 'Game',
        ]);
    }

    #[Route('/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $game->getId(), $request->request->get('_token'))) {
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_index', [], Response::HTTP_SEE_OTHER);
    }
}
