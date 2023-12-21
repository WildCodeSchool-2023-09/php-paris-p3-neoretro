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


#[Route('/dashboard', 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        return $this->render('dashboard/user.html.twig');
    }

    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('dashboard/admin.html.twig');
    }
}