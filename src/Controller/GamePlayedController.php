<?php

namespace App\Controller;

use App\Entity\GamePlayed;
use App\Service\GamePlayedService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game-played', 'game-played_')]
class GamePlayedController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        GamePlayedService $gamePlayedService,
        EntityManagerInterface $entityManager
    ): Response {
        $gamePlayed = $gamePlayedService->generate();
        $entityManager->persist($gamePlayed);
        $entityManager->flush();

        return $this->render('game_played/index.html.twig', [
            'gamePlayed' => $gamePlayed
        ]);
    }
}
