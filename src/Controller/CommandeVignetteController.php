<?php

namespace App\Controller;

use App\Entity\CommandeVignette;
use App\Form\CommandeVignetteType;
use App\Repository\CommandeVignetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Guichet;
use App\Entity\Type;
use App\Entity\Trajet;
use App\Entity\Section;
use App\Entity\BilletPtb;
use App\Entity\Ptb;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\TypeAudit;
use App\Entity\Vignette;
use App\Entity\StockVignette;
use App\Entity\VenteVignette;
use App\Entity\CommandePtb;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lieux;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande/v")
 */
class CommandeVignetteController extends AbstractController
{
    /**
     * @Route("/", name="commande_vignette_lister", methods={"GET"})
     */
    public function index(CommandeVignetteRepository $commandeVignetteRepository): Response
    {
        return $this->render('commande_vignette/index.html.twig', [
            'commande_vignettes' => $commandeVignetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_vignette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeVignette = new CommandeVignette();
        
        $form = $this->createForm(CommandeVignetteType::class, $commandeVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeVignette);
            $entityManager->flush();

            return $this->redirectToRoute('commande_vignette_lister');
        }

        return $this->render('commande_vignette/new.html.twig', [
            'commande_vignette' => $commandeVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_vignette_voir", methods={"GET"})
     */
    public function show(CommandeVignette $commandeVignette): Response
    {
        return $this->render('commande_vignette/show.html.twig', [
            'commande_vignette' => $commandeVignette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_vignette_modifiernonval", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeVignette $commandeVignette): Response
    {
        $form = $this->createForm(CommandeVignetteType::class, $commandeVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_vignette_lister', [
                'id' => $commandeVignette->getId(),
            ]);
        }

        return $this->render('commande_vignette/edit.html.twig', [
            'commande_vignette' => $commandeVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_vignette_delete2", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeVignette $commandeVignette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeVignette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeVignette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_vignette_lister');
    }
}
