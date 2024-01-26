<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\GamePlayedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        AuthenticationUtils $authenticationUtils,
        Security $security,
        GamePlayedRepository $gamePlayedRepository
    ): Response {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = $security->getUser();

        $gamesPlayed = [];
        if ($this->isGranted('ROLE_USER')) {
            $gamesPlayed = $gamePlayedRepository->findBestGamesScoresByUser($user->getId());
        }

        return $this->render('dashboard/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,
            'gamesPlayed' => $gamesPlayed,
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
        ]);
    }
}
