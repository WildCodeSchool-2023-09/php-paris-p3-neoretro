<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/game', 'game_')]
class GameController extends AbstractController
{
    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
            'pageTitle' => 'Game',
        ]);
    }
}


