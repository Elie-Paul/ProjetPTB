<?php

namespace App\Controller;

use App\Entity\VenteVignette;
use App\Form\VenteVignetteType;
use App\Repository\VenteVignetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente/vignette")
 */
class VenteVignetteController extends AbstractController
{
    /**
     * @Route("/", name="vente_vignette_index", methods={"GET"})
     */
    public function index(VenteVignetteRepository $venteVignetteRepository): Response
    {
        return $this->render('vente_vignette/index.html.twig', [
            'vente_vignettes' => $venteVignetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vente_vignette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $venteVignette = new VenteVignette();
        $form = $this->createForm(VenteVignetteType::class, $venteVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($venteVignette);
            $entityManager->flush();

            return $this->redirectToRoute('vente_vignette_index');
        }

        return $this->render('vente_vignette/new.html.twig', [
            'vente_vignette' => $venteVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_vignette_show", methods={"GET"})
     */
    public function show(VenteVignette $venteVignette): Response
    {
        return $this->render('vente_vignette/show.html.twig', [
            'vente_vignette' => $venteVignette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_vignette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VenteVignette $venteVignette): Response
    {
        $form = $this->createForm(VenteVignetteType::class, $venteVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_vignette_index', [
                'id' => $venteVignette->getId(),
            ]);
        }

        return $this->render('vente_vignette/edit.html.twig', [
            'vente_vignette' => $venteVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_vignette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VenteVignette $venteVignette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venteVignette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($venteVignette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_vignette_index');
    }
}
