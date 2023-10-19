<?php

namespace App\Controller;

use App\Entity\Automobile;
use App\Form\AutomobileType;
use App\Repository\AutomobileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/automobile')]
class AutomobileController extends AbstractController
{
    #[Route('/', name: 'app_automobile_index', methods: ['GET'])]
    public function index(AutomobileRepository $automobileRepository): Response
    {
        return $this->render('automobile/index.html.twig', [
            'automobiles' => $automobileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_automobile_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $automobile = new Automobile();
        $form = $this->createForm(AutomobileType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($automobile);
            $entityManager->flush();

            return $this->redirectToRoute('app_automobile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('automobile/new.html.twig', [
            'automobile' => $automobile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_automobile_show', methods: ['GET'])]
    public function show(Automobile $automobile): Response
    {
        return $this->render('automobile/show.html.twig', [
            'automobile' => $automobile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_automobile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Automobile $automobile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutomobileType::class, $automobile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_automobile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('automobile/edit.html.twig', [
            'automobile' => $automobile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_automobile_delete', methods: ['POST'])]
    public function delete(Request $request, Automobile $automobile, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$automobile->getId(), $request->request->get('_token'))) {
            $entityManager->remove($automobile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_automobile_index', [], Response::HTTP_SEE_OTHER);
    }
}
