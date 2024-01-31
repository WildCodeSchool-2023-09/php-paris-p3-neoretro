<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Form\GameSearchType;
use App\Form\RegistrationFormType;
use App\Form\RegistrationGameFormType;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        AuthenticationUtils $authenticationUtils,
        Security $security,
        GamePlayedRepository $gamePlayedRepository,
        GameRepository $gameRepository
    ): Response {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = $security->getUser();

        $games = $gameRepository->findBy([], ['id' => 'DESC'], 5);

        if ($this->isGranted('ROLE_USER')) {
            $bestGamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId(), 8);
            $lastGamesPlayed = $gamePlayedRepository->findBy(
                ['player' => $user->getId()],
                ['id' => 'DESC'],
                3
            );
        } else {
            $lastGamesPlayed = [];
            $bestGamesPlayed = $gamePlayedRepository->findGlobalBestGameScores();
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('dashboard/admin.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
            ]);
        }

        return $this->render('dashboard/dashboard.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'bestGamesPlayed' => $bestGamesPlayed,
            'lastGamesPlayed' => $lastGamesPlayed,
            'games' => $games
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new Exception();
    }

    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');

            return $this->redirectToRoute('dashboard');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'pageTitle' => 'NeoRetro',
        ]);
    }

    #[Route('/newgame', name: 'new_game')]
    public function game(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $game = new Game();
        $form = $this->createForm(RegistrationGameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($game->getTitle()) {
                $slug = $slugger->slug($game->getTitle());
                $game->setSlug($slug);
            }

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash("Success", "The game has been added");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }
            // $games = $entityManager->getRepository(Game::class)->findAll();
            return $this->render('admin/new_game.html.twig', [
                'registrationGameForm' => $form->createView(),
                'pageTitle' => 'Admin Add Game',
            ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{slug}/editgame', name: 'edit_game', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationGameFormType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // $this->addFlash("Success", "The game has been edited");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'registrationGameForm' => $form->createView(),
            'pageTitle' => 'Admin Edit Game',
        ]);
    }
}
