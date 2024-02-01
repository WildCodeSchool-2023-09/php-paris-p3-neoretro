<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Form\GameSearchType;
use App\Form\RegistrationFormType;
use App\Form\RegistrationGameFormType;
use App\Repository\GamePlayedRepository;
use App\Repository\GameRepository;
use App\Service\GameInfoService;
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
        GameRepository $gameRepository,
        GameInfoService $gameInfoService
    ): Response {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = $security->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('dashboard/admin.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
            ]);
        }

        $games = $gameRepository->findBy([], ['id' => 'DESC'], 5);

        if ($this->isGranted('ROLE_USER')) {
            $bestGamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId(), 8);
            $lastGamesPlayed = $gamePlayedRepository->findBy(
                ['player' => $user->getId()],
                ['id' => 'DESC'],
                3
            );

            $lastGamesDuration = [];
            foreach ($lastGamesPlayed as $lastGamePlayed) {
                $lastGamesDuration[] = $gameInfoService->formatTime($lastGamePlayed->getDuration(), 'short');
            }
        } else {
            $bestGamesPlayed = $gamePlayedRepository->findGlobalBestGameScores();
        }

        $bestGameDuration = $gameInfoService->formatTime($bestGamesPlayed[0]->getDuration(), 'short');

        return $this->render('dashboard/dashboard.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'games' => $games,
            'bestGamesPlayed' => $bestGamesPlayed,
            'bestGameDuration' => $bestGameDuration,
            'lastGamesPlayed' => $lastGamesPlayed ?? null,
            'lastGamesDuration' => $lastGamesDuration ?? null,
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
}
