<?php

namespace App\Controller;

use App\Entity\StockNavette;
use App\Form\StockNavetteType;
use App\Repository\StockNavetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock/n")
 */
class StockNavetteController extends AbstractController
{
    /**
     * @Route("/", name="stock_navette_lister", methods={"GET"})
     */
    public function index(StockNavetteRepository $stockNavetteRepository): Response
    {
        return $this->render('stock_navette/index.html.twig', [
            'stock_navettes' => $stockNavetteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="stock_navette_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stockNavette = new StockNavette();
        $form = $this->createForm(StockNavetteType::class, $stockNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stockNavette);
            $entityManager->flush();

            return $this->redirectToRoute('stock_navette_lister');
        }

        return $this->render('stock_navette/new.html.twig', [
            'stock_navette' => $stockNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_navette_voir", methods={"GET"})
     */
    public function show(StockNavette $stockNavette): Response
    {
        return $this->render('stock_navette/show.html.twig', [
            'stock_navette' => $stockNavette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_navette_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, StockNavette $stockNavette): Response
    {
        $form = $this->createForm(StockNavetteType::class, $stockNavette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_navette_lister', [
                'id' => $stockNavette->getId(),
            ]);
        }

        return $this->render('stock_navette/edit.html.twig', [
            'stock_navette' => $stockNavette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_navette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StockNavette $stockNavette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockNavette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stockNavette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_navette_lister');
    }
}
