<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Form\PartType;
use App\Repository\PartRepository;
use CarMaster\Entity\Part;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

use const FILTER_VALIDATE_REGEXP;

final class PartController extends AbstractController
{
    #[Route('/parts', name: 'app_crud_part_index', methods: ['GET'])]
    public function index(
        PartRepository $parts,
        #[MapQueryParameter(
            filter: FILTER_VALIDATE_REGEXP,
            options: ['regexp' => '/^[1-9][0-9]*$/']
        )]
        int $page = 1,
    ): Response {
        return $this->render('crud/parts/index.html.twig', [
            'parts' => $parts->findPage(max(1, $page)),
        ]);
    }

    #[Route('parts/{id}', name: 'app_crud_part_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Part $part): Response
    {
        return $this->render('crud/parts/show.html.twig', ['part' => $part]);
    }

    #[Route('parts/{id}/_delete', name: 'app_crud_part_delete')]
    public function delete(Part $part, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($part);
        $entityManager->flush();

        $this->addFlash('success', "Part {$part->getName()} deleted.");

        return $this->redirectToRoute('app_crud_part_index');
    }

    #[Route('parts/new', name: 'app_crud_part_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PartType::class, new Part());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($part = $form->getData());
            $entityManager->flush();

            $this->addFlash('success', "Part {$part->getName()} created successfully");

            return $this->redirectToRoute('app_crud_part_show', ['id' => $part->getId()]);
        }

        return $this->render('crud/parts/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('parts/{id}/_update', name: 'app_crud_part_update', requirements: ['id' => Requirement::POSITIVE_INT], methods: [
        'GET',
        'POST'
    ])]
    public function update(Part $part, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PartType::class, $part);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', "Part {$part->getName()} updated successfully");

            return $this->redirectToRoute('app_crud_part_show', ['id' => $part->getId()]);
        }

        return $this->render('crud/parts/edit.html.twig', ['part' => $part, 'form' => $form]);
    }
}