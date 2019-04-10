<?php

namespace App\Controller;

use App\Entity\CommandeTaxe;
use App\Form\CommandeTaxeType;
use App\Repository\CommandeTaxeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/t")
 */
class CommandeTaxeController extends AbstractController
{
    /**
     * @Route("/", name="commande_taxe_lister", methods={"GET"})
     */
    public function index(CommandeTaxeRepository $commandeTaxeRepository): Response
    {
        return $this->render('commande_taxe/index.html.twig', [
            'commande_taxes' => $commandeTaxeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_taxe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeTaxe = new CommandeTaxe();
        $form = $this->createForm(CommandeTaxeType::class, $commandeTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeTaxe);
            $entityManager->flush();

            return $this->redirectToRoute('commande_taxe_lister');
        }

        return $this->render('commande_taxe/new.html.twig', [
            'commande_taxe' => $commandeTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_taxe_voir", methods={"GET"})
     */
    public function show(CommandeTaxe $commandeTaxe): Response
    {
        return $this->render('commande_taxe/show.html.twig', [
            'commande_taxe' => $commandeTaxe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_taxe_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeTaxe $commandeTaxe): Response
    {
        $form = $this->createForm(CommandeTaxeType::class, $commandeTaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_taxe_lister', [
                'id' => $commandeTaxe->getId(),
            ]);
        }

        return $this->render('commande_taxe/edit.html.twig', [
            'commande_taxe' => $commandeTaxe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_taxe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeTaxe $commandeTaxe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeTaxe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeTaxe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_taxe_lister');
    }
}
