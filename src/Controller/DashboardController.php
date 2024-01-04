<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

#[Route('/', 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'guest')]
    public function guest(): Response
    {
        return $this->render('dashboard/guest.html.twig', [
            'pageTitle' => 'NeoRetro',
        ]);
    }

    #[Route('user/', name: 'user')]
    public function user(): Response
    {
        return $this->render('dashboard/user.html.twig', [
            'pageTitle' => 'Dashboard',
        ]);
    }

    #[Route('admin/', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('dashboard/admin.html.twig', [
            'pageTitle' => 'Dashboard',
            'admin' => true
        ]);
    }
}
