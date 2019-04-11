<?php

namespace App\Controller;

use App\Entity\VenteNavette;
use App\Form\VenteNavetteType;
use App\Repository\VenteNavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente/navette")
 */
class VenteNavetteController extends AbstractController
{
    /**
     * @Route("/", name="vente_navette_index", methods={"GET"})
     */
    public function index(VenteNavetteRepository $venteNavetteRepository): Response
    {
        return $this->render('vente_navette/index.html.twig', [
            'vente_navettes' => $venteNavetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vente_navette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $venteNavette = new VenteNavette();
        $form = $this->createForm(VenteNavetteType::class, $venteNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($venteNavette);
            $entityManager->flush();

            return $this->redirectToRoute('vente_navette_index');
        }

        return $this->render('vente_navette/new.html.twig', [
            'vente_navette' => $venteNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_navette_show", methods={"GET"})
     */
    public function show(VenteNavette $venteNavette): Response
    {
        return $this->render('vente_navette/show.html.twig', [
            'vente_navette' => $venteNavette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_navette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VenteNavette $venteNavette): Response
    {
        $form = $this->createForm(VenteNavetteType::class, $venteNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_navette_index', [
                'id' => $venteNavette->getId(),
            ]);
        }

        return $this->render('vente_navette/edit.html.twig', [
            'vente_navette' => $venteNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_navette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VenteNavette $venteNavette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venteNavette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($venteNavette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_navette_index');
    }
}
