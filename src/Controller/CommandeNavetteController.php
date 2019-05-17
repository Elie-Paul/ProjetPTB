<?php

namespace App\Controller;

use App\Entity\CommandeNavette;
use App\Form\CommandeNavetteType;
use App\Repository\CommandeNavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/n")
 */
class CommandeNavetteController extends AbstractController
{
    /**
     * @Route("/", name="commande_navette_lister", methods={"GET"})
     */
    public function index(CommandeNavetteRepository $commandeNavetteRepository): Response
    {
        return $this->render('commande_navette/index.html.twig', [
            'commande_navettes' => $commandeNavetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_navette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeNavette = new CommandeNavette();
        $form = $this->createForm(CommandeNavetteType::class, $commandeNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeNavette);
            $entityManager->flush();

            return $this->redirectToRoute('commande_navette_lister');
        }

        return $this->render('commande_navette/new.html.twig', [
            'commande_navette' => $commandeNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_navette_voir", methods={"GET"})
     */
    public function show(CommandeNavette $commandeNavette): Response
    {
        return $this->render('commande_navette/show.html.twig', [
            'commande_navette' => $commandeNavette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_navette_modifiernonvalider", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeNavette $commandeNavette): Response
    {
        $form = $this->createForm(CommandeNavetteType::class, $commandeNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_navette_lister', [
                'id' => $commandeNavette->getId(),
            ]);
        }

        return $this->render('commande_navette/edit.html.twig', [
            'commande_navette' => $commandeNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_navette_delete2", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeNavette $commandeNavette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeNavette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeNavette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_navette_lister');
    }
}
