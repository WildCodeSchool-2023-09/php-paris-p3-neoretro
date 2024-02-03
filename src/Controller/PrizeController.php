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

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prize = new Prize();
        $form = $this->createForm(PrizeType::class, $prize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prize);
            $entityManager->flush();

            return $this->redirectToRoute('app_prize_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prize/new.html.twig', [
            'prize' => $prize,
            'form' => $form,
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
    public function edit(
        Request $request,
        Prize $prize,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(PrizeType::class, $prize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($prize->getLabel());
            $prize->setSlug($slug);
            $entityManager->flush();

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prize/edit.html.twig', [
            'prize' => $prize,
            'form' => $form,
            'pageTitle' => 'Prizes'
        ]);
    }

    #[Route('/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Prize $prize, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prize->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prize);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prize_index', [], Response::HTTP_SEE_OTHER);
    }
}
