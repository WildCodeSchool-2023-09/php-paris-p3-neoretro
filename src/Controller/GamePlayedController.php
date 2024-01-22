<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game-played', 'game-played_')]
class GamePlayedController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $gamePlayed = null;

        return $this->render('game_played/index.html.twig', [
            'gamePlayed' => $gamePlayed
        ]);
    }
}
