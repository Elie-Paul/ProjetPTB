<?php

namespace App\Controller;

use App\Entity\StockVignette;
use App\Form\StockVignetteType;
use App\Repository\StockVignetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock/v")
 */
class StockVignetteController extends AbstractController
{
    /**
     * @Route("/", name="stock_vignette_lister", methods={"GET"})
     */
    public function index(StockVignetteRepository $stockVignetteRepository): Response
    {
        return $this->render('stock_vignette/index.html.twig', [
            'stock_vignettes' => $stockVignetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stock_vignette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stockVignette = new StockVignette();
        $form = $this->createForm(StockVignetteType::class, $stockVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockVignette);
            $entityManager->flush();

            return $this->redirectToRoute('stock_vignette_lister');
        }

        return $this->render('stock_vignette/new.html.twig', [
            'stock_vignette' => $stockVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_vignette_voir", methods={"GET"})
     */
    public function show(StockVignette $stockVignette): Response
    {
        return $this->render('stock_vignette/show.html.twig', [
            'stock_vignette' => $stockVignette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_vignette_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, StockVignette $stockVignette): Response
    {
        $form = $this->createForm(StockVignetteType::class, $stockVignette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_vignette_lister', [
                'id' => $stockVignette->getId(),
            ]);
        }

        return $this->render('stock_vignette/edit.html.twig', [
            'stock_vignette' => $stockVignette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_vignette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StockVignette $stockVignette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockVignette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockVignette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_vignette_lister');
    }
}
