<?php

namespace App\Controller;

use App\Entity\BilletNavette;
use App\Form\BilletNavetteType;
use App\Repository\BilletNavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/billet/navette")
 */
class BilletNavetteController extends AbstractController
{
    /**
     * @Route("/", name="billet_navette_index", methods={"GET"})
     */
    public function index(BilletNavetteRepository $billetNavetteRepository): Response
    {
        return $this->render('billet_navette/index.html.twig', [
            'billet_navettes' => $billetNavetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="billet_navette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $billetNavette = new BilletNavette();
        $form = $this->createForm(BilletNavetteType::class, $billetNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billetNavette);
            $entityManager->flush();

            return $this->redirectToRoute('billet_navette_index');
        }

        return $this->render('billet_navette/new.html.twig', [
            'billet_navette' => $billetNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_navette_show", methods={"GET"})
     */
    public function show(BilletNavette $billetNavette): Response
    {
        return $this->render('billet_navette/show.html.twig', [
            'billet_navette' => $billetNavette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="billet_navette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BilletNavette $billetNavette): Response
    {
        $form = $this->createForm(BilletNavetteType::class, $billetNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('billet_navette_index', [
                'id' => $billetNavette->getId(),
            ]);
        }

        return $this->render('billet_navette/edit.html.twig', [
            'billet_navette' => $billetNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="billet_navette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BilletNavette $billetNavette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$billetNavette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($billetNavette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('billet_navette_index');
    }
}