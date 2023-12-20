<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
