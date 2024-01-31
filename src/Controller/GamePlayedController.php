<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\GamePlayedRepository;
use App\Repository\ReviewRepository;
use App\Service\GamePlayedService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/game-played', 'game-played_')]
class GamePlayedController extends AbstractController
{
    #[Route('/{slug}/{uuid}', name: 'new')]
    public function new(
        Game $game,
        string $uuid,
        GamePlayedService $gamePlayedService,
        GamePlayedRepository $gamePlayedRepository,
        ReviewRepository $reviewRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        Request $request,
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

        /*if (!$review = $reviewRepository->findOneBy(['author' => $this->getUser(), 'game' => $game])) {
            $review = new Review();
        }

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }*/

        return $this->render('game_played/new.html.twig', [
            'gamePlayed' => $gamePlayed,
            'pageTitle' => 'Your last game',
            'experienceGained' => (int)floor($gamePlayed->getScore() * GamePlayedService::EXPERIENCE_COEFFICIENT),
            /*'form' => $form,*/
        ]);
    }
}
