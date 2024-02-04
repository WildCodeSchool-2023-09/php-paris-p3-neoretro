<?php

namespace App\Controller;

use App\Entity\Prize;
use App\Form\PrizeType;
use App\Repository\PrizeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/prize', 'prize_')]
class PrizeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PrizeRepository $prizeRepository): Response
    {
        return $this->render('prize/index.html.twig', [
            'prizes' => $prizeRepository->findAll(),
            'pageTitle' => 'Prizes'
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $prize = new Prize();
        $form = $this->createForm(PrizeType::class, $prize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($prize->getLabel()) {
                $slug = $slugger->slug($prize->getLabel());
                $prize->setSlug($slug);
            }
            $entityManager->persist($prize);
            $entityManager->flush();

            $this->addFlash("Success", "The prize has been added");

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prize/new.html.twig', [
            'prizeForm' => $form,
            'pageTitle' => 'Admin Add prize',
        ]);
    }

    #[Route('/{slug}', name: 'show', methods: ['GET'])]
    public function show(Prize $prize): Response
    {
        return $this->render('prize/show.html.twig', [
            'prize' => $prize,
            'pageTitle' => 'Prizes'
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Request $request,
        Prize $prize,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(PrizeType::class, $prize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->addFlash("Success", "The prize has been added");
            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prize/edit.html.twig', [
            'prizeForm' => $form,
            'pageTitle' => 'Edit prize',
        ]);
    }

    #[Route('/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Prize $prize,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $prize->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prize);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
    }
}
