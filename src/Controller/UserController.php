<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'profile')]
    public function profile(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors(true, true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/index.html.twig', [
            'pageTitle' => 'My profile',
            'user' => $this->getUser(),
            'profileForm' => $form,
        ]);
    }

    #[Route('/scores', name: 'scores')]
    public function scores(
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
    ): Response {
        $user = $security->getUser();

        $userGamesPlayed = [];
        if ($this->isGranted('ROLE_USER')) {
            $userGamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId(), 10);
        }

        $globalGamesPlayed = $gamePlayedRepository->findBy([], ['score' => 'DESC'], 50);

        return $this->render('user/scores.html.twig', [
            'pageTitle' => 'Leaderboard',
            'userGamesPlayed' => $userGamesPlayed,
            'globalGamesPlayed' => $globalGamesPlayed,
        ]);
    }
}
